<?php

namespace App\Services;

use App\DTO\PushNotificationDTO;
use App\Enum\ResponseCodeEnum;
use App\Http\Requests\SetPushSettingsRequest;
use App\Models\PushNotification;
use App\Response\Model\ResponseObject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PushNotificationService extends BaseService
{
    public function getPushSettings(Request $request)
    {
        $pushSetting = Auth::user()->pushNotification;

        $response = new ResponseObject(ResponseCodeEnum::CODE_1000, $pushSetting->toArray());
        return $this->responseData($response);
    }

    public function createPushSettings($userId) {
        $pushNotification = new PushNotification();
        $pushNotification->user_id = $userId;
        $pushNotification->save();
    }

    public function setPushSettings(SetPushSettingsRequest $setPushSettingsRequest)
    {
        try {
            DB::beginTransaction();
            $pushSetting = Auth::user()->pushNotification;

            $pushSetting->like_comment = $setPushSettingsRequest->like_comment;
            $pushSetting->from_friends = $setPushSettingsRequest->from_friends;
            $pushSetting->requested_friends = $setPushSettingsRequest->requested_friends;
            $pushSetting->suggested_friend = $setPushSettingsRequest->suggested_friend;
            $pushSetting->birthday = $setPushSettingsRequest->birthday;
            $pushSetting->video = $setPushSettingsRequest->video;
            $pushSetting->report = $setPushSettingsRequest->report;
            $pushSetting->sound_on = $setPushSettingsRequest->sound_on;
            $pushSetting->notification_on = $setPushSettingsRequest->notification_on;
            $pushSetting->vibrant_on = $setPushSettingsRequest->vibrant_on;
            $pushSetting->led_on = $setPushSettingsRequest->led_on;

            $pushSetting->save();

            DB::commit();

            $response = new ResponseObject(ResponseCodeEnum::CODE_1000);

            return $this->responseData($response);

        } catch (\Exception $e)
        {
            DB::rollBack();
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9999);
            return $this->responseData($responseError);
        }
    }
}
