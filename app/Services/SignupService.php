<?php

namespace App\Services;

use App\Enum\ResponseCodeEnum;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use App\Models\VerifyCode;
use App\Repository\UserRepository;
use App\Response\Model\ResponseObject;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SignupService extends BaseService
{
    private UserRepository $userRepository;
    private PushNotificationService $pushNotificationService;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserRepository $userRepository,
        PushNotificationService $pushNotificationService
    )
    {
        $this->userRepository = $userRepository;
        $this->pushNotificationService = $pushNotificationService;
    }

    public function signup(SignupRequest $signupRequest)
    {
        try {
            DB::beginTransaction();
            $foundUser = $this->userRepository->getUserByEmail($signupRequest->email);

            if ($foundUser) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_9996);

                return $this->responseData($responseError);
            }

            $user = new User();
            $user->email = $signupRequest->email;
            $user->password = bcrypt($signupRequest->password);
            $user->uuid = $signupRequest->uuid;
            $user->coins = 100;
            $user->save();

            $verifyCode = new VerifyCode();
            $verifyCode->user_id = $user->id;
            $verifyCode->expiry_at = Carbon::now()->addDays();
            $verifyCode->token = $this->genVerifyToken();

            $verifyCode->save();

            $this->pushNotificationService->createPushSettings($user->id);

            DB::commit();

            $response = new ResponseObject(ResponseCodeEnum::CODE_1000, $verifyCode->toArray());

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
