<?php

namespace App\Services;

use App\Enum\ResponseCodeEnum;
use App\Enum\StatusUserEnum;
use App\Http\Requests\CheckVerifyCodeRequest;
use App\Http\Requests\GetVerifyCodeRequest;
use App\Models\VerifyCode;
use App\Repository\UserRepository;
use App\Response\Model\ResponseObject;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VerifyCodeService extends BaseService
{
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getVerifyCode (GetVerifyCodeRequest $getVerifyCodeRequest)
    {
        try {
            DB::beginTransaction();
            $foundUser = $this->userRepository->getUserByEmail($getVerifyCodeRequest->email);
            if (!$foundUser) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_9995);
                return $this->responseData($responseError);
            }

            if ($foundUser->status_user == StatusUserEnum::ACTIVE) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_1010);
                return $this->responseData($responseError);
            }

            $verifyCode = new VerifyCode();
            $verifyCode->user_id = $foundUser->id;
            $verifyCode->expiry_at = Carbon::now()->addDays();
            $verifyCode->token = $this->genVerifyToken();

            $verifyCode->save();
            DB::commit();

            $response = new ResponseObject(ResponseCodeEnum::CODE_1000, $verifyCode->toArray());

            return $this->responseData($response);
        } catch (\Exception $e) {
            DB::rollBack();
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9999);
            return $this->responseData($responseError);
        }
    }

    public function checkVerifyCode(CheckVerifyCodeRequest $checkVerifyCodeRequest)
    {
        try {
            DB::beginTransaction();
            $foundUser = $this->userRepository->getUserByEmail($checkVerifyCodeRequest->email);

            if (!$foundUser) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_9995);
                return $this->responseData($responseError);
            }

            if ($foundUser->status_user == StatusUserEnum::ACTIVE) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_9996);
                return $this->responseData($responseError);
            }

            if ($foundUser->listVerifyCode->isEmpty()) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_1009);
                return $this->responseData($responseError);
            }

            if (! in_array($checkVerifyCodeRequest->code_verify, $foundUser->listVerifyCode->pluck('token')->all())) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_1009);
                return $this->responseData($responseError);
            }

            $foundUser->status_user = StatusUserEnum::ACTIVE;
            $foundUser->email_verified_at = Carbon::now();
            $foundUser->save();

            VerifyCode::where('token', $checkVerifyCodeRequest->code_verify)->delete();

            $token = $foundUser->createToken($foundUser->email)->plainTextToken;

            $data = [
                "id" => $foundUser->id,
                "active" => $foundUser->status_user,
                "token" => $token
            ];

            DB::commit();

            $response = new ResponseObject(ResponseCodeEnum::CODE_1000, $data);

            return $this->responseData($response);
        } catch (\Exception $e) {
            DB::rollBack();
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9999);
            return $this->responseData($responseError);
        }
    }

    private function genVerifyToken()
    {
        return Str::random(6);
    }
}
