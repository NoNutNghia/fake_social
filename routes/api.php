<?php

use App\Enum\ResponseCodeEnum;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PeopleRelationshipController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PushNotificationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\VerifyCodeController;
use App\Http\Controllers\VersionController;
use App\Response\Model\ResponseObject;
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

Route::middleware('db.connection')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/signup', [SignupController::class, 'signup']);
    Route::post('/get_verify_code', [VerifyCodeController::class, 'getVerifyCode'])->middleware('throttle:1,2');
    Route::post('/check_verify_code', [VerifyCodeController::class, 'checkVerifyCode']);

    Route::middleware(['auth:sanctum', 'auth.status'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/change_info_after_sign_up', [AuthController::class, 'changeInfoAfterSignUp']);
        Route::post('/add_post', [PostController::class, 'addPost']);
        Route::post('/get_post', [PostController::class, 'getPost']);
        Route::post('/delete_post', [PostController::class, 'deletePost']);
        Route::post('/report_post', [PostController::class, 'reportPost']);
        Route::post('/feel', [PostController::class, 'feel']);
        Route::post('/get_mark_comment', [PostController::class, 'getMarkComment']);
        Route::post('/set_mark_comment', [PostController::class, 'setMarkComment']);
        Route::post('/search', [SearchController::class, 'searchPost']);
        Route::post('/get_saved_search', [SearchController::class, 'getSavedSearch']);
        Route::post('/del_saved_search', [SearchController::class, 'deleteSavedSearch']);
        Route::post('/get_requested_friends', [PeopleRelationshipController::class, 'getRequestedFriends']);
        Route::post('/set_accept_friend', [PeopleRelationshipController::class, 'setAcceptFriend']);
        Route::post('/set_request_friend', [PeopleRelationshipController::class, 'setRequestFriend']);
        Route::post('/get_list_blocks', [PeopleRelationshipController::class, 'getListBlocks']);
        Route::post('/change_password', [AuthController::class, 'changePassword']);
        Route::post('/get_push_settings', [PushNotificationController::class, 'getPushSettings']);
        Route::post('/set_push_settings', [PushNotificationController::class, 'setPushSettings']);
        Route::post('/set_block', [PeopleRelationshipController::class, 'setBlock']);
        Route::post('/check_new_version', [VersionController::class, 'checkNewVersion']);
//        Route::post('/get_notification');
//        Route::post('set_read_notification');
//        Route::post('/set_devtoken');
        Route::post('/get_user_info', [AuthController::class, 'getUserInfo']);
        Route::post('set_user_info', [AuthController::class, 'setUserInfo']);
    });

    Route::fallback(function () {
        $responseError = new ResponseObject(ResponseCodeEnum::CODE_9997);
        return response()->json($responseError->toArray());
    });
});
