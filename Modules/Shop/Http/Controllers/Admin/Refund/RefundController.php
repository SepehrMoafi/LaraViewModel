<?php

namespace Modules\Shop\Http\Controllers\Admin\Refund;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class RefundController
{
    public function index(MasterViewModel $masterViewModel)
    {
        return $masterViewModel->setModule('Shop')
            ->setViewModel('admin.refund.refund')
            ->setAction('showGrid')->render();
    }

    public function show($model_id, Request $request, MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Shop')
            ->setRequest($request, ['model_id' => $model_id])
            ->setViewModel('admin.refund.refund')
            ->setAction('show')
            ->render();
    }

    public function approve($model_id, Request $request, MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Shop')
            ->setRequest($request, ['model_id' => $model_id])
            ->setViewModel('admin.refund.refund')
            ->setAction('approve')
            ->render();
    }
}
