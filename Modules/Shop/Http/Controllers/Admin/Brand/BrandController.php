<?php

namespace Modules\Shop\Http\Controllers\Admin\Brand;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class BrandController
{
    /**
     * Display a listing of the resource.
     * @param MasterViewModel $masterViewModel
     * @return mixed
     */
    public function index( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Shop')
            ->setViewModel('admin.brand.brand')
            ->setAction('showGrid')->render();
    }

    public function create(MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setViewModel('admin.brand.brand_action')
            ->setAction('create')
            ->render();
    }

    public function store(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setRequest($request)
            ->setViewModel('admin.brand.brand_action')
            ->setAction('store')
            ->render();
    }
    public function edit($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.brand.brand_action')
            ->setAction('edit')
            ->render();
    }

    public function update($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.brand.brand_action')
            ->setAction('update')
            ->render();
    }

    public function destroy($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.brand.brand_action')
            ->setAction('destroy')
            ->render();
    }

}
