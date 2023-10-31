<?php

namespace Modules\Shop\Http\Controllers\Front;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class CartController
{
    public function index(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setViewModel('front.cart.cart')
            ->setAction('index')
            ->render();
    }

    public function increaseQty($model_id , Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['cart_row_id' => $model_id ] )
            ->setViewModel('front.cart.cart')
            ->setAction('increaseQty')
            ->render();
    }

    public function decreaseQty($model_id , Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['cart_row_id' => $model_id ] )
            ->setViewModel('front.cart.cart')
            ->setAction('decreaseQty')
            ->render();
    }

    public function addProductToCart( Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setViewModel('front.cart.cart')
            ->setAction('addProductToCart')
            ->render();
    }

    public function checkout( Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setViewModel('front.cart.checkout')
            ->setAction('checkout')
            ->render();
    }

    public function saveCheckout( Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setViewModel('front.cart.checkout')
            ->setAction('saveCheckout')
            ->render();
    }


    public function CheckCopan( Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setViewModel('front.cart.checkout')
            ->setAction('checkCopan')
            ->render();
    }

}
