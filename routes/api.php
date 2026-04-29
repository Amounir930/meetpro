<?php

use App\Http\Controllers\API\MeetingController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/create-meeting', [MeetingController::class, 'createMeeting']);
Route::post('/edit-meeting', [MeetingController::class, 'editMeeting']);
Route::post('/delete-meeting', [MeetingController::class, 'deleteMeeting']);

Route::post('/create-user', [UserController::class, 'createUser']);
Route::post('/edit-user', [UserController::class, 'editUser']);
Route::post('/delete-user', [UserController::class, 'deleteUser']);

Route::post('/create-plugin-user', [UserController::class, 'createPluginUser']);

