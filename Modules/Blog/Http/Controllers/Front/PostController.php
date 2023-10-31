<?php

namespace Modules\Blog\Http\Controllers\Front;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class PostController
{
    public function index(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Blog')
            ->setViewModel('front.post.post')
            ->setAction('index')
            ->render();
    }

    public function show($model_id , Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Blog')
            ->setRequest( $request)
            ->setViewModel('front.post.post')
            ->setAction('show')
            ->render();
    }

    public function decreaseQty($model_id , Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Blog')
            ->setRequest( $request , ['cart_row_id' => $model_id ] )
            ->setViewModel('front.post.post')
            ->setAction('decreaseQty')
            ->render();
    }

    public function addProductToCart( Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Blog')
            ->setViewModel('front.post.post')
            ->setAction('addProductToCart')
            ->render();
    }

    public function checkout( Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Blog')
            ->setViewModel('front.post.post')
            ->setAction('checkout')
            ->render();
    }

    public function saveCheckout( Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Blog')
            ->setViewModel('front.post.post')
            ->setAction('saveCheckout')
            ->render();
    }


    public function CheckCopan( Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Blog')
            ->setViewModel('front.post.post')
            ->setAction('checkCopan')
            ->render();
    }

}
