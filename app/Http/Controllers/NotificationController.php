<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetNotificationRequest;
use App\Http\Requests\SetReadNotificationRequest;
use App\Services\NotificationService;

class NotificationController extends Controller
{
    private NotificationService $notificationService;

    /**
     * @param NotificationService $notificationService
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function getNotification(GetNotificationRequest $getNotificationRequest)
    {
        return $this->notificationService->getNotification($getNotificationRequest);
    }

    public function setReadNotification(SetReadNotificationRequest $setReadNotificationRequest)
    {
        return $this->notificationService->setReadNotification($setReadNotificationRequest);
    }
}
