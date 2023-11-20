<?php

namespace App\Services;

use App\Enum\NotificationReadEnum;
use App\Enum\ResponseCodeEnum;
use App\Http\Requests\GetNotificationRequest;
use App\Http\Requests\SetReadMessageRequest;
use App\Http\Requests\SetReadNotificationRequest;
use App\Models\Notification;
use App\Response\Model\ResponseObject;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationService extends BaseService
{
    public function getNotification(GetNotificationRequest $getNotificationRequest)
    {
        if (isset($getNotificationRequest->index) && isset($getNotificationRequest->count)) {
            $listNotification = Notification::where('user_id', Auth::user()->id)
                ->offset($getNotificationRequest->index)
                ->limit($getNotificationRequest->count)
                ->get();
        } else {
            $listNotification = Notification::where('user_id', Auth::user()->id)->get();
        }

        $countNewNotification = Notification::where('user_id', Auth::user()->id)
            ->where('read', NotificationReadEnum::UN_READ)->count();

        $data = [
            'list_notification' => $listNotification,
            'last_update' => Carbon::now(),
            'badge' => $countNewNotification
        ];

        $response = new ResponseObject(ResponseCodeEnum::CODE_1000, $data);

        return $this->responseData($response);
    }

    public function setReadNotification(SetReadNotificationRequest $setReadNotificationRequest)
    {
        try {
            DB::beginTransaction();

            $foundNotification = Notification::where('id', $setReadNotificationRequest->notification_id)
                ->where('user_id', Auth::user()->id)
                ->where('read', NotificationReadEnum::UN_READ)
                ->first();

            if (!$foundNotification) {
                $responseError = new ResponseObject(ResponseCodeEnum::CODE_9994);
                return $this->responseData($responseError);
            }

            $foundNotification->read = NotificationReadEnum::READ;
            $foundNotification->save();

            DB::commit();

            $countNotificationNotRead = Notification::where('user_id', Auth::user()->id)
                ->where('read', NotificationReadEnum::UN_READ)
                ->count();

            $data = [
                'badge' => $countNotificationNotRead,
                'last_update' => Carbon::now()
            ];

            $response = new ResponseObject(ResponseCodeEnum::CODE_1000, $data);

            return $this->responseData($response);

        } catch (\Exception $e) {
            DB::rollBack();
            $responseError = new ResponseObject(ResponseCodeEnum::CODE_9999);
            return $this->responseData($responseError);
        }
    }
}
