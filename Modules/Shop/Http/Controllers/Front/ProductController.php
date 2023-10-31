<?php

namespace Modules\Shop\Http\Controllers\Front;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class ProductController
{

    public function index(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setViewModel('front.product.product')
            ->setAction('index')
            ->render();
    }

    public function show($model_id , Request $request , MasterViewModel $masterViewModel)
    {

        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('front.product.product')
            ->setAction('show')
            ->render();
    }




}
