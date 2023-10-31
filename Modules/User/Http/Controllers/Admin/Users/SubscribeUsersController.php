<?php

namespace Modules\User\Http\Controllers\Admin\Users;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class SubscribeUsersController
{
    /**
     * Display a listing of the resource.
     * @param MasterViewModel $masterViewModel
     * @return mixed
     */
    public function index( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('User')
            ->setViewModel('admin.user.subscribeUsers')
            ->setAction('showGrid')->render();
    }
    public function destroy($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('User')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.user.user_action')
            ->setAction('destroy')
            ->render();
    }

}
