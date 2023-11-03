<?php

namespace App\Services;

use App\DTO\PushNotificationDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PushNotificationService
{
    public function editPushNotification(Request $request)
    {
        $pushNotificationDTO = new PushNotificationDTO(
            $request->noti_request,
            $request->noti_post_by_myself,
            $request->noti_comment,
            $request->noti_request,
            $request->noti_react_comment,
            $request->noti_post_by_friend,
        );

        $pushNotificationUser = Auth::user()->userPushNotification;
    }
}
