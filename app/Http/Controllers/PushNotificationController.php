<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetPushSettingsRequest;
use App\Services\PushNotificationService;
use Illuminate\Http\Request;

class PushNotificationController extends Controller
{
    private PushNotificationService $pushNotificationService;

    /**
     * @param PushNotificationService $pushNotificationService
     */
    public function __construct(PushNotificationService $pushNotificationService)
    {
        $this->pushNotificationService = $pushNotificationService;
    }

    public function getPushSettings(Request $request)
    {
        return $this->pushNotificationService->getPushSettings($request);
    }

    public function setPushSettings(SetPushSettingsRequest $setPushSettingsRequest)
    {
        return $this->pushNotificationService->setPushSettings($setPushSettingsRequest);
    }

}
