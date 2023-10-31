<?php

namespace Modules\User\Http\Controllers\Admin\Users;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class SendSmsController
{
    /**
     * Display a listing of the resource.
     * @param MasterViewModel $masterViewModel
     * @return mixed
     */
    public function index( MasterViewModel $masterViewModel )
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('admin.user.sendSms')
            ->setAction('index')
            ->render();
    }
    public function sendSms(Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('User')
            ->setRequest( $request )
            ->setViewModel('admin.user.sendSms')
            ->setAction('sendSms')
            ->render();
    }

}
