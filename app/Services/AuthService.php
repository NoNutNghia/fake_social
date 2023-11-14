<?php

namespace App\Services;

use App\Enum\ResponseCodeEnum;
use App\Enum\StatusUserEnum;
use App\Helper\UploadImageHelper;
use App\Http\Requests\ChangeInfoAfterSignupRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\GetUserInfoRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SetUserInfoRequest;
use App\Models\User;
use App\Repository\UserRepository;
use App\Response\Model\ResponseObject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function changePassword(ChangePasswordRequest $changePasswordRequest)
    {
        try {
            DB::beginTransaction();
            Auth::user()->password = bcrypt($changePasswordRequest->new_password);
            Auth::user()->save();

            $response = new ResponseObject(ResponseCodeEnum::CODE_1000);

            return $this->responseData($response);
        } catch (\Exception $e) {
            DB::rollBack();
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9999);
            return $this->responseData($responseError);
        }
    }

    public function getUserInfo(GetUserInfoRequest $getUserInfoRequest)
    {
        $user = !$getUserInfoRequest->user_id ? Auth::user() : User::where('id', $getUserInfoRequest->user_id)->first();

        if (!$user) {
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9995);
            return $this->responseData($responseError);
        }

        $user['listing'] = $user->listFriends->count();
        $data = collect($user);
        if ($user->id != Auth::user()->id) {
            $data['is_friend'] = Auth::user()->listFriends->pluck('user_id')->contains($user->id);
            $data->forget(['coins']);
        }

        $data->forget(['list_friends']);
        $data['online'] = 1;

        $response = new ResponseObject(ResponseCodeEnum::CODE_1000, $data->toArray());

        return $this->responseData($response);
    }

    public function setUserInfo(SetUserInfoRequest $setUserInfoRequest)
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();

            $user->username = $setUserInfoRequest->username ?? "";
            $user->description = $setUserInfoRequest->description ?? "";
            $user->address = $setUserInfoRequest->address ?? "";
            $user->city = $setUserInfoRequest->city ?? "";
            $user->country = $setUserInfoRequest->country ?? "";
            $user->link = $setUserInfoRequest->link ?? "";

            if ($setUserInfoRequest->hasFile('avatar')) {
                $resultDeleteAvatar = true;

                if ($user->avatar) {
                    $resultDeleteAvatar = UploadImageHelper::deleteImage($user->avatar);
                }

                if ($resultDeleteAvatar) {
                    $newPathAvatar = UploadImageHelper::uploadAvatar($setUserInfoRequest->file('avatar'), $user->id);
                    $user->avatar = $newPathAvatar;
                }
            }

            if ($setUserInfoRequest->hasFile('cover_image')) {
                $resultDeleteCoverImage = true;

                if ($user->cover_image) {
                    $resultDeleteCoverImage = UploadImageHelper::deleteImage($user->cover_image);
                }

                if ($resultDeleteCoverImage) {
                    $newPathCoverImage = UploadImageHelper::uploadCoverImage($setUserInfoRequest->file('cover_image'), $user->id);
                    $user->cover_image = $newPathCoverImage;
                }
            }

            $user->save();
            DB::commit();

            $response = new ResponseObject(ResponseCodeEnum::CODE_1000);
            return $this->responseData($response);

        } catch (\Exception $e) {
            DB::rollBack();
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9999);
            return $this->responseData($responseError);
        }
    }
}
