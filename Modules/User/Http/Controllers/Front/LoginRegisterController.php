<?php
namespace Modules\User\Http\Controllers\Front;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class LoginRegisterController{
    public function loginRegisterForm(Request $request, MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('front.LoginRegister.loginRegisterForm')
            ->setAction('loginRegisterForm')
            ->render();
    }

    public function loginRegister(Request $request, MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('front.LoginRegister.loginRegister')
            ->setAction('loginRegister')
            ->render();
    }

    public function loginConfirmForm(Request $request, MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('front.loginRegister.LoginConfirmForm')
            ->setAction('loginConfirmForm')
            ->render();
    }

    public function loginConfirm(Request $request, MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('front.LoginRegister.loginConfirm')
            ->setAction('loginConfirm')
            ->render();
    }

    public function loginResendOtp(Request $request, MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('front.LoginRegister.loginResendOtp')
            ->setAction('loginResendOtp')
            ->render();
    }

}
