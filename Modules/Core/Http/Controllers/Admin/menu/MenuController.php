<?php

namespace Modules\Core\Http\Controllers\Admin\menu;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class MenuController
{
    /**
     * Display a listing of the resource.
     * @param MasterViewModel $masterViewModel
     * @return mixed
     */
    public function index( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Core')
            ->setViewModel('admin.menu.menu')
            ->setAction('showGrid')->render();
    }

    public function create(MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Core')
            ->setViewModel('admin.menu.menu_action')
            ->setAction('create')
            ->render();
    }

    public function store(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Core')
            ->setRequest($request)
            ->setViewModel('admin.menu.menu_action')
            ->setAction('store')
            ->render();
    }
    public function edit($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Core')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.menu.menu_action')
            ->setAction('edit')
            ->render();
    }

    public function update($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Core')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.menu.menu_action')
            ->setAction('update')
            ->render();
    }

    public function destroy($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Core')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.menu.menu_action')
            ->setAction('destroy')
            ->render();
    }

}
