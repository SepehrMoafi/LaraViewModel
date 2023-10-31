<?php

namespace Modules\Shop\Http\Controllers\Admin\Product;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class ProductController
{
    /**
     * Display a listing of the resource.
     * @param MasterViewModel $masterViewModel
     * @return mixed
     */
    public function index( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Shop')
            ->setViewModel('admin.product.product_grid')
            ->setAction('showGrid')->render();
    }

    public function updateTaraz( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Shop')
            ->setViewModel('admin.product.product_taraz')
            ->setAction('updateTaraz')->render();
    }

    public function create(MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setViewModel('admin.product.product_action')
            ->setAction('create')
            ->render();
    }

    public function store(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setRequest($request)
            ->setViewModel('admin.product.product_action')
            ->setAction('store')
            ->render();
    }
    public function edit($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.product.product_action')
            ->setAction('edit')
            ->render();
    }

    public function update($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.product.product_action')
            ->setAction('update')
            ->render();
    }

    public function destroy($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('admin.product.product_action')
            ->setAction('destroy')
            ->render();
    }

    public function updateTarazWithText( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Shop')
            ->setViewModel('admin.product.product_taraz')
            ->setAction('updateTarazWithText')->render();
    }

    public function updateTarazWithTextSubmit( MasterViewModel $masterViewModel )
    {
        return $masterViewModel->setModule('Shop')
            ->setViewModel('admin.product.product_taraz')
            ->setAction('updateTarazWithTextSubmit')->render();
    }

    public function lowCount(MasterViewModel $masterViewModel)
    {
        return $masterViewModel->setModule('Shop')
            ->setViewModel('admin.product.lowCountProductGrid')
            ->setAction('showGrid')->render();
    }


}
