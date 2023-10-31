<?php

use Illuminate\Support\Facades\Route;
use Modules\Shop\Http\Controllers\Admin\Attribute\AttributeController;
use Modules\Shop\Http\Controllers\Admin\Brand\BrandController;
use Modules\Shop\Http\Controllers\Admin\Copan\CopanController;
use Modules\Shop\Http\Controllers\Admin\Delivery\DeliveryController;
use Modules\Shop\Http\Controllers\Admin\LuckyWheel\LuckyWheelController;
use Modules\Shop\Http\Controllers\Admin\Order\OrderController;
use Modules\Shop\Http\Controllers\Admin\Payment\PaymentController;
use Modules\Shop\Http\Controllers\Admin\Product\ProductController;
use Modules\Shop\Http\Controllers\Admin\ProductCatalog\ProductCatalogController;
use Modules\Shop\Http\Controllers\Admin\ProductCatalogCategory\ProductCatalogCategoryController;
use Modules\Shop\Http\Controllers\Admin\Refund\RefundController;

Route::prefix('admin')->name('admin.')->middleware(['web', 'admin', 'auth'])->group(function () {

    Route::prefix('shop')->name('shop.')->group(function () {

        Route::resource('product-catalog', ProductCatalogController::class);

        Route::prefix('product')->name('product.')->group(function () {
            Route::get('/update-taraz', [ProductController::class, 'updateTaraz'])->name('update-taraz');

            Route::get('/update-taraz-with-text', [ProductController::class, 'updateTarazWithText'])->name('update-taraz-with-text');
            Route::post('/update-taraz-with-text', [ProductController::class, 'updateTarazWithTextSubmit'])->name('update-taraz-with-text');
        });
        Route::resource('product', ProductController::class);
        Route::get('lowCount/products', [ProductController::class,'lowCount'])->name('product.lowCount');


        Route::resource('product-catalog-category', ProductCatalogCategoryController::class);

        Route::resource('brand', BrandController::class);

        Route::resource('attribute', AttributeController::class);


        Route::prefix('payments')->name('payments.')->group(function () {
            Route::get('/', [PaymentController::class, 'index'])->name('index');
            Route::get('/edit/{id}', [PaymentController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [PaymentController::class, 'update'])->name('update');
            Route::get('/bank-rec', [PaymentController::class, 'indexRec'])->name('index-rec');
        });


        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/edit/{id}', [OrderController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [OrderController::class, 'update'])->name('update');
            Route::get('/factor/{id}', [OrderController::class, 'factor'])->name('factor');
            Route::get('/send_api/{id}', [OrderController::class, 'sendApi'])->name('send_api');
        });

        // lucky wheel
        Route::prefix('luckyWheel')->name('luckyWheel.')->group(function () {
            Route::get('/', [LuckyWheelController::class, 'index'])->name('index');
            Route::get('/winners', [LuckyWheelController::class, 'winners'])->name('winners');
            Route::post('/', [LuckyWheelController::class, 'store'])->name('store');
            Route::get('/create', [LuckyWheelController::class, 'create'])->name('create');
            Route::get('/{id}', [LuckyWheelController::class, 'edit'])->name('edit');
            Route::put('/{id}', [LuckyWheelController::class, 'update'])->name('update');
            Route::delete('/{id}', [LuckyWheelController::class, 'destroy'])->name('destroy');
        });
        // refund
        Route::prefix('refund')->as('refund.')->group(function (){
            Route::get('/',[RefundController::class,'index'])->name('index');
            Route::get('/show/{id}',[RefundController::class,'show'])->name('show');
            Route::put('/show/{id}',[RefundController::class,'approve'])->name('approve');
        });

        //discount
        Route::prefix('copan')->name('copan.')->group(function () {
            Route::get('', [CopanController::class, 'index'])->name('index');
            Route::get('/create', [CopanController::class, 'create'])->name('create');
            Route::post('/store', [CopanController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [CopanController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [CopanController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [CopanController::class, 'destroy'])->name('destroy');
        });

        Route::resource('delivery', DeliveryController::class);
    });

});
