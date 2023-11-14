<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeInfoAfterSignupRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\GetUserInfoRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SetUserInfoRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    private AuthService $authService;

    /**
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        return $this->authService->login($request);
    }

    public function test(Request $request) {
        return Auth::user();
    }

    public function logout(Request $request)
    {
        return $this->authService->logout($request);
    }

    public function changeInfoAfterSignUp(ChangeInfoAfterSignupRequest $changeInfoAfterSignupRequest)
    {
        return $this->authService->changeInfoAfterSignUp($changeInfoAfterSignupRequest);
    }

    public function changePassword(ChangePasswordRequest $changePasswordRequest)
    {
        return $this->authService->changePassword($changePasswordRequest);
    }

    public function getUserInfo(GetUserInfoRequest $getUserInfoRequest)
    {
        return $this->authService->getUserInfo($getUserInfoRequest);
    }

    public function setUserInfo(SetUserInfoRequest $setUserInfoRequest)
    {
        return $this->authService->setUserInfo($setUserInfoRequest);
    }
}
