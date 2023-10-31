<?php

namespace Modules\User\ViewModels\Front\LoginRegister;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\User\Entities\UserToken;

class LoginConfirmViewModel extends BaseViewModel
{
    public function loginConfirm()
    {
        $token = request()->otp;
        $otp = UserToken::where('token', $token)->where('created_at', '>=', Carbon::now()->subMinute(5)->toDateTimeString())->first();
        if (empty($otp)) {
            $errorText = 'کد وارد شده نامعتبر میباشد';
            alert()->toast($errorText, 'error');
            return redirect()->route('front.user.auth.customer.login-register-form');
        }

        //if otp not match
        if ($otp->token !== $token) {
            $errorText = 'کد وارد شده صحیح نمیباشد';
            alert()->toast($errorText, 'error');
            return redirect()->route('front.user.auth.customer.login-confirm-form');
        }

        // if everything is ok :
        $otp->update(['status' => 1]);
        $user = $otp->user()->first();
        if ($otp->type == 0 && empty($user->mobile_verified_at)) {
            $user->update(['mobile_verified_at' => Carbon::now()]);
        } elseif ($otp->type == 1 && empty($user->email_verified_at)) {
            $user->update(['email_verified_at' => Carbon::now()]);
        }
        Auth::login($user);
        alert()->toast('خوش آمدید!', 'success');
        return redirect()->route('front.user.profile.index');
    }

}
