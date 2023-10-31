<?php

use Illuminate\Support\Facades\Route;
use Modules\Shop\Http\Controllers\Front\LuckyWheel;

Route::name('front.')->middleware(['web'])->group(function() {

    Route::prefix('shop')->name('shop.')->group(function (){
        Route::prefix('products')->name('product.')->group(function (){
            Route::get('/',[\Modules\Shop\Http\Controllers\Front\ProductController::class , 'index'])->name('products');
            Route::get('/{id}',[\Modules\Shop\Http\Controllers\Front\ProductController::class , 'show'])->name('show-product');

        });

        Route::prefix('refund')->name('refund.')->group(function (){
            Route::post('/{item_id}',[\Modules\Shop\Http\Controllers\Front\RefundController::class , '__invoke'])->name('refund');

        });

        Route::prefix('cart')->name('cart.')->group(function (){
            Route::get('/',[\Modules\Shop\Http\Controllers\Front\CartController::class , 'index'])->name('index');
            Route::get('/add-product-to-cart',[\Modules\Shop\Http\Controllers\Front\CartController::class , 'addProductToCart'])->name('add-product-to-cart');
            Route::get('/increase-qty/{id}',[\Modules\Shop\Http\Controllers\Front\CartController::class , 'increaseQty'])->name('increase-qty');
            Route::get('/decrease-qty/{id}',[\Modules\Shop\Http\Controllers\Front\CartController::class , 'decreaseQty'])->name('decrease-qty');

            Route::get('/checkout',[\Modules\Shop\Http\Controllers\Front\CartController::class , 'checkout'])->name('checkout')->middleware('auth');
            Route::get('/checkCopan',[\Modules\Shop\Http\Controllers\Front\CartController::class , 'checkCopan'])->name('checkCopan')->middleware('auth');
            Route::post('/save-checkout',[\Modules\Shop\Http\Controllers\Front\CartController::class , 'saveCheckout'])->name('save-checkout')->middleware('auth');;
        });

        Route::prefix('compare')->name('compare.')->group(function (){
            Route::get('/',[\Modules\Shop\Http\Controllers\Front\CompareController::class , 'index'])->name('index');
            Route::get('/add_item/{id}',[\Modules\Shop\Http\Controllers\Front\CompareController::class , 'addItem'])->name('add_item');
            Route::get('/remove_item/{id}',[\Modules\Shop\Http\Controllers\Front\CompareController::class , 'removeItem'])->name('remove_item');
            Route::delete('/remove', [\Modules\Shop\Http\Controllers\Front\CompareController::class, 'remove'])->name('removeCompare');
        });

        Route::get('/fastBuy',[\Modules\Shop\Http\Controllers\Front\FastBuyController::class , 'index'])->name('buy-fast.index');
        Route::middleware('auth')->get('/luckyWheel/{id}',[LuckyWheel::class , 'show'])->name('show.lucky-wheel');
        Route::middleware('auth')->post('/luckyWheel/{id}',[LuckyWheel::class , 'win'])->name('win.lucky-wheel');


        Route::prefix('payment')->name('payment.')->group(function (){
            Route::post('/order-payment-callback',[\Modules\Shop\Http\Controllers\Front\PaymentController::class , 'callBack'])->name('order-payment-callback');
        });




    });
});
