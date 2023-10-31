<?php

namespace Modules\User\Http\Controllers\Front;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class WalletController
{
    public function WalletPayForm(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('front.wallet.wallet')
            ->setAction('WalletPayForm')
            ->render();
    }

    public function walletPaySubmit(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('front.wallet.wallet')
            ->setAction('walletPaySubmit')
            ->render();
    }
}
