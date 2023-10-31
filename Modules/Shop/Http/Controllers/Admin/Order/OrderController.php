<?php

namespace Modules\Shop\Http\Controllers\Admin\Order;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class OrderController
{
    /**
     * Display a listing of the resource.
     * @param MasterViewModel $masterViewModel
     * @return mixed
     */
    public function index( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Shop')
            ->setViewModel('admin.order.order')
            ->setAction('showGrid')->render();
    }

    public function edit($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.order.order_action')
            ->setAction('edit')
            ->render();
    }
    public function update($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.order.order_action')
            ->setAction('update')
            ->render();
    }

    public function delete($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.order.order_action')
            ->setAction('destroy')
            ->render();
    }

    public function sendApi($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.order.order_action')
            ->setAction('sendApi')
            ->render();
    }

    public function factor($model_id , Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('User')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('front.profile.profile')
            ->setAction('ordersPdf')
            ->render();
    }

}
