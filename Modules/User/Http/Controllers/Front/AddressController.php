<?php

namespace Modules\User\Http\Controllers\Front;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class AddressController
{

    public function index(Request $request, MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('front.address.addressIndex')
            ->setAction('index')
            ->render();
    }

    public function create(Request $request, MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('front.address.addressCreate')
            ->setAction('create')
            ->render();
    }

    public function store(Request $request, MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('front.address.addressStore')
            ->setAction('store')
            ->render();
    }

    public function show(Request $request, MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('front.address.addressShow')
            ->setAction('show')
            ->render();
    }

    public function edit(Request $request, MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setViewModel('front.address.addressEdit')
            ->setAction('edit')
            ->render();
    }

    public function update($model_id , Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('front.address.addressUpdate')
            ->setAction('update')
            ->render();
    }

    public function destroy($model_id , Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('front.address.addressDestroy')
            ->setAction('destroy')
            ->render();
    }
}
