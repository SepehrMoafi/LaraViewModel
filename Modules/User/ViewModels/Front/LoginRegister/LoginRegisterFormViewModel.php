<?php

namespace Modules\User\ViewModels\Front\LoginRegister;

use Modules\Core\ViewModels\BaseViewModel;

class loginRegisterFormViewModel extends BaseViewModel
{
    public function loginRegisterForm()
    {
        return $this->renderView('user::loginRegister.loginConfirmForm');
    }
}
