<?php

use App\Enum\ResponseCodeEnum;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\VerifyCodeController;
use App\Response\Model\ResponseObject;
use Illuminate\Http\Request;
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

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/change_info_after_sign_up', [AuthController::class, 'changeInfoAfterSignUp']);
        Route::post('/add_post', [PostController::class, 'addPost']);
    });

    Route::fallback(function () {
        $responseError = new ResponseObject(ResponseCodeEnum::CODE_9997);
        return response()->json($responseError->toArray());
    });
});

Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'test']);
