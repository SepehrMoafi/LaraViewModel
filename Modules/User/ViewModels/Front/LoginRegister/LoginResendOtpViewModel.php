<?php

namespace Modules\User\ViewModels\Front\LoginRegister;


use App\Http\Services\Message\Email\EmailService;
use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\SMS\SmsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Modules\User\Entities\UserToken;

class LoginResendOtpViewModel
{
    public function loginResendOtp($token)
    {
        $otp = UserToken::query()->findOrFail(session()->get('key'));
        $user = $otp->user()->first();
        //create otp code
        $otpCode = rand(1111, 9999);
        $otpInputs = [
            'token' => $otpCode,
            'user_id' => $user->id,
            'type' => $otp->type,
            'status' => 1,
        ];

        UserToken::create($otpInputs);

        if($otp->type == 0){
            //send sms
            $smsService = new SmsService();
            $smsService->setFrom(Config::get('sms.otp_from'));
            $smsService->setTo(['0' . $user->mobile]);
            $smsService->setText(env('APP_NAME')."مجموعه  \n  کد تایید : $otpCode");
            $smsService->setIsFlash(true);
            $successText = 'کد ورود برای شما پیامک شد';
            alert()->toast($successText, 'success');
            $messagesService = new MessageService($smsService);

        }

        elseif($otp->type === 1){
            $emailService = new EmailService();
            $details = [
                'title' => 'ایمیل فعال سازی',
                'body' => "کد فعال سازی شما : $otpCode"
            ];
            $emailService->setDetails($details);
            $emailService->setFrom('noreply@example.com', 'example');
            $emailService->setSubject('کد احراز هویت');
            $emailService->setTo($otp->login_id);
            $successText = 'کد ورود برای شما ایمیل شد';
            alert()->toast($successText, 'success');
            $messagesService = new MessageService($emailService);

        }

        $messagesService->send();

        return redirect()->route('front.user.auth.customer.login-confirm-form');

    }

}
