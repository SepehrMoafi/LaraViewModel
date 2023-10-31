<?php

namespace Modules\Shop\Http\Controllers\Admin\ProductCatalog;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class ProductCatalogController
{
    /**
     * Display a listing of the resource.
     * @param MasterViewModel $masterViewModel
     * @return mixed
     */
    public function index( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Shop')
            ->setViewModel('admin.product_catalog.product_catalog_grid')
            ->setAction('showGrid')->render();
    }

    public function create(MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setViewModel('admin.product_catalog.product_catalog_action')
            ->setAction('create')
            ->render();
    }

    public function store(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setRequest($request)
            ->setViewModel('admin.product_catalog.product_catalog_action')
            ->setAction('store')
            ->render();
    }
    public function edit($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.product_catalog.product_catalog_action')
            ->setAction('edit')
            ->render();
    }

    public function update($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.product_catalog.product_catalog_action')
            ->setAction('update')
            ->render();
    }

    public function destroy($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.product_catalog.product_catalog_action')
            ->setAction('destroy')
            ->render();
    }




}
