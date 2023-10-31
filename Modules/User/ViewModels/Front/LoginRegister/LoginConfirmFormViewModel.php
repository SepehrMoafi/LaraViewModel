<?php

namespace Modules\User\ViewModels\Front\LoginRegister;

use Modules\Core\ViewModels\BaseViewModel;

class LoginConfirmFormViewModel extends BaseViewModel
{
    public function loginConfirmForm(){
        if (session()->has('key')){
            return $this->renderView('user::loginRegister.confirmCode');
        }
        return to_route('front.user.auth.customer.login-register');
    }

}
