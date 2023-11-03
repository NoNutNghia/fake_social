<?php

namespace App\Services;

use App\Enum\ResponseCodeEnum;
use App\Enum\StatusUserEnum;
use App\Http\Requests\ChangeInfoAfterSignupRequest;
use App\Http\Requests\LoginRequest;
use App\Repository\UserRepository;
use App\Response\Model\ResponseObject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService extends BaseService
{
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(LoginRequest $request) {
        try {
            $email = $request->email;
            $password = $request->password;

            $credentials = [
                'email' => $email,
                'password' => $password,
                'status_user' => StatusUserEnum::ACTIVE,
            ];

            if (Auth::attempt($credentials)) {
                $this->clearTokenUser();

                $token = Auth::user()->createToken(Auth::user()->username ?: Auth::user()->email)->plainTextToken;

                $data = Auth::user()->toArray();
                $data['token'] = $token;
                $response = new ResponseObject(ResponseCodeEnum::CODE_1000, $data);

                return $this->responseData($response);
            }

            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9995);
            return $this->responseData($responseError);

        } catch (\Exception $e) {
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9999);
            return $this->responseData($responseError);
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->clearTokenUser();
            $response = new ResponseObject(ResponseCodeEnum::CODE_1000);
            return $this->responseData($response);
        } catch (\Exception $e) {
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9999);
            return $this->responseData($responseError);
        }
    }

    public function changeInfoAfterSignUp(ChangeInfoAfterSignupRequest $changeInfoAfterSignupRequest)
    {
        Auth::user()->username = $changeInfoAfterSignupRequest->username;
        Auth::user()->save();
        return response()->json(["data" => Auth::user()->toArray()]);
    }

    private function clearTokenUser()
    {
        Auth::user()->tokens()->delete();
    }
}
