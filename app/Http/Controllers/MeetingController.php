<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use stdClass;

class MeetingController extends Controller
{
    //show meeting page
    public function meeting($id)
    {
        $meeting = new \stdClass();

        if (getSetting('AUTH_MODE') == 'enabled') {
            $meeting = Meeting::where(['meeting_id' => $id, 'status' => 'active'])->first();
            $user = User::where(['username' => $id, 'status' => 'active'])->first();

            if (!$meeting && !$user) {
                return redirect('/')->withErrors(__('The meeting does not exist'));
            }

            //for personal/instant meeting link
            if ($user) {
                $allowedMeetings = getUserPlanFeatures($user->id)->meeting_no;
                if ($allowedMeetings != -1 && count($user->meeting) >= $allowedMeetings) {
                    if (Auth::check()) {
                        return redirect()->route('dashboard')->withErrors(__('You have reached the maximum meeting creation limit. Upgrade now'));
                    } else {
                        return redirect('/')->withErrors(__('The meeting does not exist'));
                    }
                }

                $meeting = new stdClass();
                $meeting->title = __('Personal Meeting');
                $meeting->user_id = $user->id;
                $meeting->meeting_id = $id;
                $meeting->date = null;
                $meeting->time = null;
                $meeting->timezone = '';
                $meeting->description = '';
                $meeting->password = '';
            }

            $meeting->features = getUserPlanFeatures($meeting->user_id);
        } else {
            $meeting->title = __('Meeting');
            $meeting->meeting_id = $id;
            $meeting->description = '-';
            $meeting->password = null;
            $meeting->user_id = 0;
            $meeting->features = Plan::first()->features;
            $meeting->date = null;
            $meeting->time = null;
            $meeting->timezone = '';
        }

        $meeting->isModerator = Auth::user() && getSetting('MODERATOR_RIGHTS') == "enabled" ? Auth::user()->id == $meeting->user_id : false;
        $meeting->username = Auth::user() ? Auth::user()->username : '';
        $meeting->timeLimit = isDemoMode() ? 10 : $meeting->features->time_limit;
        $meeting->userLimit = $meeting->features->user_limit ?? 5;
        $meeting->isAdmin = Auth::user() && getSetting('MODERATOR_RIGHTS') == "enabled" ? Auth::user()->role == 'admin' : false;

        return view('meeting', [
            'page' => __('Meeting'),
            'meeting' => $meeting
        ]);
    }

    //get the application details and send it to the user
    public function getDetails()
    {
        $details = new stdClass();
        $details->defaultUsername = getSetting('DEFAULT_USERNAME');
        $details->appName = getSetting('APPLICATION_NAME');
        $details->signalingURL = getSetting('SIGNALING_URL');
        $details->authMode = getSetting('AUTH_MODE');
        $details->moderatorRights = getSetting('MODERATOR_RIGHTS');
        $details->endURL = getSetting('END_URL');
        $details->limitedScreenShare = getSetting('LIMITED_SCREEN_SHARE');
        $details->aiChatbot = getSetting('AI_CHATBOT');


        return json_encode(['success' => true, 'data' => $details]);
    }
    //api to store the file in storage folder when it is uploaded in chat
    public function fileUploads(Request $request)
    {
        try {
            if (!$request->meetingId) {
                return response()->json([
                    'success' => false,
                    'statusCode' => 500,
                    'message' => __('Something went wrong'),
                ]);
            }

            $meeting = Meeting::where('meeting_id', $request->meetingId)->first();

            if (!isset($meeting)) {
                $user = User::where('username', $request->meetingId)->first();
            } else {
                $user = $meeting->user;
            }

            $maxFileSizeMB = $user->plan->features->max_filesize;
            $maxFileSizeKB = $maxFileSizeMB * 1024;

            $validator = Validator::make($request->all(), [
                'file' => "required|file|max:$maxFileSizeKB",
                'meetingId' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'statusCode' => 500,
                    'message' => __('The uploaded file exceeds the maximum allowed size.'),
                ]);
            }


            // get the file and meeting id  
            $file = $request->file('file');
            $meetingId = $request->meetingId;

            //set file folder path
            $folderPath = 'file_uploads/' . $meetingId;

            // store the file in declared path
            $originalFilename = $file->getClientOriginalName();
            $path = $file->storeAs($folderPath, $originalFilename);

            return response()->json([
                'success' => true,
                'statusCode' => 200,
                'file_name' => $originalFilename,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'statusCode' => 500,
                'message' => __('Something went wrong'),
            ]);
        }
    }

    // api to delete the folder when meeting ends
    public function deleteFolder(Request $request)
    {
        try {

            //get the folder path
            $folderPath = storage_path("app/public/file_uploads/" . $request->meetingId);

            //if folder exists in the path then delete it
            if (File::exists($folderPath)) {
                File::deleteDirectory($folderPath);
            }

        } catch (\Exception $e) {
            Log::info('Error while deleting the meeting file folder' . $e->getMessage());
        }
    }

    //check if meeting password is valid or not
    public function checkMeetingPassword(Request $request)
    {
        $meeting = Meeting::find($request->id);

        if ($meeting->password == $request->password) {
            return json_encode(['success' => true]);
        }

        return json_encode(['success' => false]);
    }

    //show widget for whiteboard
    public function widget()
    {
        return view('widget');
    }

    public function getNodejsDetails(Request $request)
    {
        $apiToken = $request->header('X-Api-Token');
        $validToken = env('SIGNALING_TOKEN');

        if (!$apiToken || $apiToken !== $validToken) {
            return response()->json(['success' => false, 'message' => 'Unauthorized domain'], 403);
        }

        $nodejs = new stdClass();
        $nodejs->keyPath = getSetting('KEY_PATH');
        $nodejs->certPath = getSetting('CERT_PATH');
        $nodejs->port = getSetting('PORT');
        $nodejs->ip = getSetting('IP');
        $nodejs->announcedIp = getSetting('ANNOUNCED_IP');
        $nodejs->rtcMinPort = getSetting('RTC_MIN_PORT');
        $nodejs->rtcMaxPort = getSetting('RTC_MAX_PORT');
        $nodejs->aiChatbot = getSetting('AI_CHATBOT');
        $nodejs->aiChatbotApiKey = getSetting('AI_CHATBOT_API_KEY');
        $nodejs->aiChatbotApiUrl = getAiChatbotUrl(getSetting('AI_CHATBOT'));
        $nodejs->aiChatbotModel = getSetting('AI_CHATBOT_MODEL');
        $nodejs->aiChatbotSeconds = getSetting('AI_CHATBOT_SECONDS');
        $nodejs->aiChatbotMessageLimit = getSetting('AI_CHATBOT_MESSAGE_LIMIT');
        $nodejs->aiChatbotMaxConversationLength = getSetting('AI_CHATBOT_MAX_CONVERSATION_LENGTH');

        return json_encode(['success' => true, 'data' => $nodejs]);
    }

}
