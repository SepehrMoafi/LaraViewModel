<?php

namespace Modules\User\Notifications;

use App\Http\Services\Message\MessageService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Services\Message\SMS\SmsService;

class SmsNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $mobileNumber;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($mobileNumber)
    {
        $this->mobileNumber = $mobileNumber;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['sms'];
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toSms($notifiable)
    {
        $smsService = new SmsService();
        $smsService->setFrom(\Illuminate\Support\Facades\Config::get('sms.otp_from'));
        $smsService->setTo(['+989198950549']);
        $smsService->setText('test');
        $smsService->setIsFlash(true);

        $messageService=new MessageService($smsService);
        $messageService->send();
    }
}
