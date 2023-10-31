<?php

namespace Modules\Shop\Http\Controllers\Admin\LuckyWheel;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class LuckyWheelController
{
    /**
     * Display a listing of the resource.
     * @param MasterViewModel $masterViewModel
     * @return mixed
     */
    public function index(MasterViewModel $masterViewModel)
    {
        return $masterViewModel->setModule('Shop')
            ->setViewModel('admin.luckyWheel.luckyWheel')
            ->setAction('showGrid')->render();
    }
    public function winners(MasterViewModel $masterViewModel)
    {
        return $masterViewModel->setModule('Shop')
            ->setViewModel('admin.luckyWheel.luckyWheelWinners')
            ->setAction('showGrid')->render();
    }

    public function create(Request $request, MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setRequest($request)
            ->setViewModel('admin.luckyWheel.luckyWheel')
            ->setAction('create')
            ->render();
    }

    public function store(Request $request, MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setRequest($request)
            ->setViewModel('admin.luckyWheel.luckyWheel')
            ->setAction('store')
            ->render();
    }

    public function edit($model_id, Request $request, MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Shop')
            ->setRequest($request, ['model_id' => $model_id])
            ->setViewModel('admin.luckyWheel.luckyWheel')
            ->setAction('edit')
            ->render();
    }

    public function update($model_id, Request $request, MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Shop')
            ->setRequest($request, ['model_id' => $model_id])
            ->setViewModel('admin.luckyWheel.luckyWheel')
            ->setAction('update')
            ->render();
    }

    public function factor($model_id, Request $request, MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Shop')
            ->setRequest($request, ['model_id' => $model_id])
            ->setViewModel('admin.luckyWheel.luckyWheel')
            ->setAction('factor')
            ->render();
    }
    public function destroy($model_id, Request $request, MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Shop')
            ->setRequest($request, ['model_id' => $model_id])
            ->setViewModel('admin.luckyWheel.luckyWheel')
            ->setAction('destroy')
            ->render();
    }
}
