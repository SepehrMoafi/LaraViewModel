<?php

namespace Modules\User\Notifications;

use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\SMS\SmsService;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;

class SmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);

        $text = $notification->text;
        $smsService = new SmsService();
        $smsService->setFrom(Config::get('sms.otp_from'));
        $smsService->setTo([$notifiable->mobile]);
        $smsService->setText($text);
        $smsService->setIsFlash(true);
        $messageService = new MessageService($smsService);
        $messageService->send();
    }
}
