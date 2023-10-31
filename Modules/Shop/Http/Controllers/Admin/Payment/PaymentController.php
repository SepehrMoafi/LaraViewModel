<?php

namespace Modules\Shop\Http\Controllers\Admin\Payment;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class PaymentController
{
    /**
     * Display a listing of the resource.
     * @param MasterViewModel $masterViewModel
     * @return mixed
     */
    public function index( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Shop')
            ->setViewModel('admin.payment.payment')
            ->setAction('showGrid')->render();
    }

    public function indexRec( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Shop')
            ->setViewModel('admin.payment.payment_rec')
            ->setAction('showGrid')->render();
    }

    public function edit($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.payment.payment_rec')
            ->setAction('edit')
            ->render();
    }
    public function update($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.payment.payment_rec')
            ->setAction('update')
            ->render();
    }

}
