<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CreateUserPluginRequest;
use App\Http\Requests\API\CreateUserRequest;
use App\Http\Requests\API\UpdateUserRequest;
use App\Jobs\SendUserCreationEmail;
use App\Models\ApiToken;
use App\Models\Plugin;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // Create a new user through API
    public function createUser(CreateUserRequest $request)
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

            // Check if authorised user is admin and is not deleted
            $user = User::where(['id' => $userId, 'role' => 'admin'])->first();
            if (!$user) {
                return response()->json(['success' => false, 'data' => "", "message" => "User not found or user is not admin."], 404);
            }

            // Return if application is in demo mode
            if (isDemoMode()) {
                return response()->json(['success' => false, 'data' => "", "message" => "This Feature is not available in demo mode."], 404);
            }

            // Create new user
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->country_id = $request->country_id ?? null;
            $user->save();

            // Get details of user and notify him with an email
            $details = [
                'username' => $user->username,
                'email' => $user->email,
                'password' => $request->password,
            ];

            SendUserCreationEmail::dispatch($details);

            if (getSetting('VERIFY_USERS') == 'enabled') {
                $user->sendEmailVerificationNotification();
            }

            return response()->json(['success' => true, 'data' => $user, "message" => "User created successfully."], 200);

        } catch (Exception $e) {
            return response()->json(['success' => false, 'data' => "", "message" => $e->getMessage()], 404);
        }
    }

    // Update existing user details via API
    public function editUser(UpdateUserRequest $request)
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

            // Check if authorised user is admin and is not deleted
            $user = User::where(['id' => $userId, 'role' => 'admin'])->first();
            if (!$user) {
                return response()->json(['success' => false, 'data' => "", "message" => "User not found or user is not admin."], 404);
            }

            // Return if application is in demo mode
            if (isDemoMode()) {
                return response()->json(['success' => false, 'data' => "", "message" => "This Feature is not available in demo mode."], 404);
            }

            // Update user if present
            $endUser = User::find($request->id);
            if (!$endUser) {
                return response()->json(['success' => false, 'data' => "", "message" => "End User not found."], 404);
            }

            $endUser->first_name = $request->first_name ?? $endUser->first_name;
            $endUser->last_name = $request->last_name ?? $endUser->last_name;
            $endUser->username = $request->username ?? $endUser->username;
            $endUser->email = $request->email ?? $endUser->email;
            $endUser->password = $request->password ?? $endUser->password;
            $endUser->status = $request->status ?? $endUser->status;


            if ($endUser->save()) {
                return response()->json(['success' => true, 'data' => $endUser, "message" => "User updated successfully."], 200);
            }

        } catch (Exception $e) {
            return response()->json(['success' => false, 'data' => "", "message" => $e->getMessage()], 404);
        }

    }

    // Delete existing user through API
    public function deleteUser(Request $request)
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

            // Check if authorised user is admin and is not deleted
            $user = User::where(['id' => $userId, 'role' => 'admin'])->first();
            if (!$user) {
                return response()->json(['success' => false, 'data' => "", "message" => "User not found or user is not admin."], 404);
            }

            if (!$request->id) {
                return response()->json(['success' => false, 'data' => "", "message" => "Resource ID not found."], 404);
            }

            // Return if application is in demo mode
            if (isDemoMode()) {
                return response()->json(['success' => false, 'data' => "", "message" => "This Feature is not available in demo mode."], 404);
            }

            // Delete user if present
            $enduser = User::find($request->id);
            if (!$enduser) {
                return response()->json(['success' => false, 'data' => "", "message" => "End User not found."], 404);
            }

            $enduser->delete();
            return response()->json(['success' => true, 'data' => "", "message" => "User deleted successfully."], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'data' => "", "message" => $e->getMessage()], 404);
        }
    }

    public function createPluginUser(CreateUserPluginRequest $request)
    {
        try {
            $authToken = $request->bearerToken();

            // Check if Authorization Bearer Token is present or not
            if (!$authToken) {
                return response()->json(['success' => false, 'data' => "", "message" => "Token not found."], 401);
            }

            $pluginToken = Plugin::where([
                'token' => $authToken,
                'status' => 'active',
                'product_id' => $request->product_id,
                'domain' => $request->domain
            ])->first();

            // Check if Authorization Bearer Token matches the token stored in database
            if (!$pluginToken) {
                return response()->json(['success' => false, 'data' => "", "message" => "Invalid token or domain."], 401);
            }

            // Check if the user already exists
            $existingUser = User::where('email', $request->email)->first();

            if ($existingUser) {
                return response()->json([
                    'success' => true,
                    'data' => $existingUser,
                    "message" => "User already exists."
                ], 200);
            }

            // Create new user
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = Hash::make(Str::random(12));
            $user->country_id = $request->country_id ?? null;
            $user->save();

            // Get details of user and notify him with an email
            $details = [
                'username' => $user->username,
                'email' => $user->email,
                'password' => $user->password,
            ];

            SendUserCreationEmail::dispatch($details);

            if (getSetting('VERIFY_USERS') == 'enabled') {
                $user->sendEmailVerificationNotification();
            }

            return response()->json(['success' => true, 'data' => $user, "message" => "User created successfully."], 200);

        } catch (Exception $e) {
            return response()->json(['success' => false, 'data' => "", "message" => $e->getMessage()], 404);
        }
    }

}