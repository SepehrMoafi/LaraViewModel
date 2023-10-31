<?php

namespace Modules\Shop\Http\Controllers\Front;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class CompareController
{
    public function index(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setViewModel('front.compare.compare')
            ->setAction('index')
            ->render();
    }

    public function addItem($model_id , Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['item_id' => $model_id ] )
            ->setViewModel('front.compare.compare')
            ->setAction('addItem')
            ->render();
    }

    public function removeItem($model_id , Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['item_id' => $model_id ] )
            ->setViewModel('front.compare.compare')
            ->setAction('removeItem')
            ->render();
    }
    public function remove(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request )
            ->setViewModel('front.compare.compare')
            ->setAction('remove')
            ->render();
    }

}
