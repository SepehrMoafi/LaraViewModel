<?php

namespace Modules\User\ViewModels\Front\LoginRegister;

use App\Http\Services\Message\Email\EmailService;
use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\SMS\SmsService;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\User\Entities\UserToken;
use Modules\User\Notifications\NewsletterSubscriptionNotification;

class LoginRegisterViewModel extends BaseViewModel
{
    public function loginRegister()
    {
        $inputs = request()->all();

        //check id is email or not
        if (filter_var($inputs['id'], FILTER_VALIDATE_EMAIL)) {
            $type = 1; // 1 => email
            $user = User::where('email', $inputs['id'])->first();
            if (empty($user)) {
                $newUser['email'] = $inputs['id'];
            }
        } //check id is mobile or not
        elseif (preg_match('/^(\+98|98|0)9\d{9}$/', $inputs['id'])) {
            $type = 0; // 0 => mobile;


            // all mobile numbers are in on format 9** *** ***
            $inputs['id'] = ltrim($inputs['id'], '0');
            $inputs['id'] = str_starts_with($inputs['id'], '98') ? substr($inputs['id'], 2) : $inputs['id'];
            $inputs['id'] = str_replace('+98', '', $inputs['id']);

            $user = User::where('mobile', $inputs['id'])->first();
            if (empty($user)) {
                $newUser['mobile'] = $inputs['id'];
            }
        } else {
            $errorText = 'شناسه ورودی شما نه شماره موبایل است نه ایمیل';
            alert()->toast($errorText, 'error');
            return redirect()->back()->withInput();
        }

        if(empty($user)){
            $newUser['password'] = 'this is a fake password';
            $newUser['email'] = $this->generateTemporaryEmail();
            $newUser['name'] = $inputs['id'];
            $user = User::create($newUser);
        }

        //create otp code
        $otpCode = rand(1111, 9999);
        $otpInputs = [
            'token' => $otpCode,
            'user_id' => $user->id,
            'type' => $type,
            'status' => 1,
        ];

        $UserToken=UserToken::create($otpInputs);

        //send sms or email

        if ($type == 0) {
            //send sms
            $user->notifyNow(new NewsletterSubscriptionNotification("فروشگاه آرشا \n  کد تایید : $otpCode"));
            $successText = 'کد ورود برای شما پیامک شد';
            alert()->toast($successText, 'success');

        }
//        elseif ($type === 1) {
//            $emailService = new EmailService();
//            $details = [
//                'title' => 'ایمیل فعال سازی',
//                'body' => "کد فعال سازی شما : $otpCode"
//            ];
//            $emailService->setDetails($details);
//            $emailService->setFrom('noreply@example.com', 'example');
//            $emailService->setSubject('کد احراز هویت');
//            $emailService->setTo($inputs['id']);
//
//            $messagesService = new MessageService($emailService);
//            $successText = 'کد ورود برای شما ایمیل شد';
//            alert()->toast($successText, 'success');
//        }

        session(['key' => $UserToken->id]);
        return redirect()->route('front.user.auth.customer.login-confirm-form');
    }
    function  generateTemporaryEmail()
    {
        $email='';
        do {
            $randomString = Str::random(8);
            $email = "user{$randomString}@mail.com";
        } while (User::where('email', $email)->exists());

        return $email;
    }

}
