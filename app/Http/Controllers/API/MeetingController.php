<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CreateMeetingRequest;
use App\Http\Requests\API\UpdateMeetingRequest;
use App\Models\ApiToken;
use App\Models\Meeting;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MeetingController extends Controller
{
    // Create a new meeting from API
    public function createMeeting(CreateMeetingRequest $request)
    {
        try {
            $authToken = $request->bearerToken();

            // Check if Authorization Bearer Token is present or not
            if (!$authToken) {
                return response()->json(['success' => false, 'data' => "", "message" => "Token not found."], 401);
            }

            $apiToken = ApiToken::where('token', $authToken)->first();

            // Check if Authorization Bearer Token matches the token stored in database
            if (!$apiToken) {
                return response()->json(['success' => false, 'data' => "", "message" => "Invalid Token."], 401);
            } else {

                // If token is valid then set last_accessed value of that token to current datetime
                activity()->disableLogging();
                $apiToken->last_accessed = now();
                $apiToken->save();
                activity()->enableLogging();
            }

            $userId = $apiToken->user_id;

            // Check if the user associated with that token is active and not deleted
            $user = User::where(['id' => $userId, 'status' => 'active'])->first();
            if (!$user) {
                return response()->json(['success' => false, 'data' => "", "message" => "User not found or status is inactive."], 404);
            }

            // Return if users total number of meetings exceeds according to his plan
            $allowedMeetings = getUserPlanFeatures($userId)->meeting_no;
            if ($allowedMeetings != -1 && $user->meeting()->count() >= $allowedMeetings) {
                return response()->json(['success' => false, 'data' => "", "message" => "You have reached the maximum meeting creation limit. Upgrade now."], 404);
            }

            // Create new meeting
            $meeting = new Meeting();
            $meeting->meeting_id = Str::random(9);
            $meeting->title = $request->title;
            $meeting->description = $request->description ?? null;
            $meeting->user_id = $userId;
            $meeting->password = $request->password ?? null;
            $meeting->date = $request->date ?? null;
            $meeting->time = $request->time ?? null;
            $meeting->timezone = $request->timezone ?? null;

            if ($meeting->save()) {
                $meeting->date = formatDate($meeting->date);
                $meeting->time = formatTime($meeting->time);
                $meeting->link = route('meeting', ['id' => $meeting->meeting_id]);

                return response()->json(['success' => true, 'data' => $meeting, "message" => "Meeting created successfully."], 200);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'data' => "", "message" => $e->getMessage()], 404);
        }

    }

    // Update existing meeting through API
    public function editMeeting(UpdateMeetingRequest $request)
    {
        try {
            $authToken = $request->bearerToken();

            // Check if Authorization Bearer Token is present or not
            if (!$authToken) {
                return response()->json(['success' => false, 'data' => "", "message" => "Token not found."], 401);
            }

            $apiToken = ApiToken::where('token', $authToken)->first();

            // Check if Authorization Bearer Token matches the token stored in database
            if (!$apiToken) {
                return response()->json(['success' => false, 'data' => "", "message" => "Invalid Token."], 401);
            } else {

                // If token is valid then set last_accessed value of that token to current datetime
                activity()->disableLogging();
                $apiToken->last_accessed = now();
                $apiToken->save();
                activity()->enableLogging();
            }

            $userId = $apiToken->user_id;

            // Check if the user associated with that token is active and not deleted
            $user = User::where(['id' => $userId, 'status' => 'active'])->first();
            if (!$user) {
                return response()->json(['success' => false, 'data' => "", "message" => "User not found or status is inactive."], 404);
            }

            $meeting = Meeting::find($request->id);

            // Check if the meeting with the resource ID is not deleted
            if (!$meeting) {
                return response()->json(['success' => false, 'data' => "", "message" => "Meeting not found with this resource ID."], 404);
            }

            // Check if the Authorised user ID is same as the user ID associated with the meeting
            if ($meeting->user_id != $userId) {
                return response()->json(['success' => false, 'data' => "", "message" => "This resource ID is not associated with authorised user."], 404);
            }

            $meeting->title = $request->title ?? $meeting->title;
            $meeting->description = $request->description ?? $meeting->description;
            $meeting->password = $request->password ?? $meeting->password;
            $meeting->date = $request->date ?? $meeting->date;
            $meeting->time = $request->time ?? $meeting->time;
            $meeting->timezone = $request->timezone ?? $meeting->timezone;

            if ($meeting->save()) {
                $meeting->date = formatDate($meeting->date);
                $meeting->time = formatTime($meeting->time);
                $meeting->link = route('meeting', ['id' => $meeting->meeting_id]);

                return response()->json(['success' => true, 'data' => $meeting, "message" => "Meeting updated Successfully."], 200);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'data' => "", "message" => $e->getMessage()], 404);
        }
    }

    // Delete existing meeting through API
    public function deleteMeeting(Request $request)
    {
        try {
            $authToken = $request->bearerToken();

            // Check if Authorization Bearer Token is present or not
            if (!$authToken) {
                return response()->json(['success' => false, 'data' => "", "message" => "Token not found."], 401);
            }

            $apiToken = ApiToken::where('token', $authToken)->first();

            // Check if Authorization Bearer Token matches the token stored in database
            if (!$apiToken) {
                return response()->json(['success' => false, 'data' => "", "message" => "Invalid Token."], 401);
            } else {

                // If token is valid then set last_accessed value of that token to current datetime
                activity()->disableLogging();
                $apiToken->last_accessed = now();
                $apiToken->save();
                activity()->enableLogging();
            }

            $userId = $apiToken->user_id;

            // Check if the user associated with that token is active and not deleted
            $user = User::where(['id' => $userId, 'status' => 'active'])->first();
            if (!$user) {
                return response()->json(['success' => false, 'data' => "", "message" => "User not found or status is inactive."], 404);
            }

            if (!$request->id) {
                return response()->json(['success' => false, 'data' => "", "message" => "Resource ID not found."], 404);
            }

            $meeting = Meeting::find($request->id);

            // Check if the meeting with the resource ID is not deleted
            if (!$meeting) {
                return response()->json(['success' => false, 'data' => "", "message" => "Meeting not found with this resource ID."], 404);
            }

            // Check if the Authorised user ID is same as the user ID associated with the meeting
            if ($meeting->user_id != $userId) {
                return response()->json(['success' => false, 'data' => "", "message" => "This resource ID is not associated with authorised user."], 404);
            }

            $userId = $meeting->user_id;

            if ($meeting->delete()) {
                return response()->json(['success' => true, 'data' => "", "message" => "Meeting deleted successfully."], 200);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'data' => "", "message" => $e->getMessage()], 404);
        }
    }
}