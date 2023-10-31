<?php

use Modules\User\Http\Controllers\Admin\Users\NewsletterSubscriptionController;
use Modules\User\Http\Controllers\Front\AddressController;
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Front\LoginRegisterController;

Route::name('front.')->middleware(['web'])->group(function() {

    Route::prefix('user')->name('user.')->group(function (){

        Route::prefix('profile')->name('profile.')->middleware(['auth'])->group(function (){

            Route::get('/',[\Modules\User\Http\Controllers\Front\ProfileController::class , 'index'])->name('index');
            Route::get('/edit-profile',[\Modules\User\Http\Controllers\Front\ProfileController::class , 'editProfile'])->name('edit-profile');
            Route::post('/edit-profile-submit',[\Modules\User\Http\Controllers\Front\ProfileController::class , 'editProfileSubmit'])->name('edit-profile-submit');

            Route::get('/company-register-1',[\Modules\User\Http\Controllers\Front\ProfileController::class , 'companyRegister_1'])->name('company-register-1');
            Route::post('/company-register-submit-1',[\Modules\User\Http\Controllers\Front\ProfileController::class , 'companyRegisterSubmit_1'])->name('company-register-submit-1');

            Route::get('/company-register-2',[\Modules\User\Http\Controllers\Front\ProfileController::class , 'companyRegister_2'])->name('company-register-2');
            Route::post('/company-register-submit-2',[\Modules\User\Http\Controllers\Front\ProfileController::class , 'companyRegisterSubmit_2'])->name('company-register-submit-2');

            Route::get('/favorite',[\Modules\User\Http\Controllers\Front\ProfileController::class , 'favorite'])->name('favorite');
            Route::get('/user-notify-items',[\Modules\User\Http\Controllers\Front\ProfileController::class , 'userNotifyItems'])->name('user-notify-items');
            Route::get('/payments',[\Modules\User\Http\Controllers\Front\ProfileController::class , 'payments'])->name('payments');

            Route::get('/orders',[\Modules\User\Http\Controllers\Front\ProfileController::class , 'orders'])->name('orders');
            Route::get('/orders-show/{id}',[\Modules\User\Http\Controllers\Front\ProfileController::class , 'ordersShow'])->name('orders-show');
            Route::get('/orders-get-pdf/{id}',[\Modules\User\Http\Controllers\Front\ProfileController::class , 'ordersPdf'])->name('orders-pdf');
            Route::get('/orders-repay/{id}',[\Modules\User\Http\Controllers\Front\ProfileController::class , 'ordersRepay'])->name('orders-repay');

            Route::get('/address',[\Modules\User\Http\Controllers\Front\ProfileController::class , 'address'])->name('address');
            Route::get('/comments',[\Modules\User\Http\Controllers\Front\ProfileController::class , 'comments'])->name('comments');
            Route::get('/notifications',[\Modules\User\Http\Controllers\Front\ProfileController::class , 'notifications'])->name('notifications');
            Route::get('add-item-to-fav/{id}',[\Modules\User\Http\Controllers\Front\ProfileController::class , 'addItemToFav'])->name('add-item-to-fav');
            Route::get('add-item-to-notify/{id}',[\Modules\User\Http\Controllers\Front\ProfileController::class , 'addItemToNotify'])->name('add-item-to-notify');

//          tickets
            Route::get('tickets', [\Modules\User\Http\Controllers\Front\ProfileController::class,'tickets'])->name('tickets');
            Route::get('clients/tickets/{id}', [\Modules\User\Http\Controllers\Front\ProfileController::class,'ticketShow'])->name('client.tickets.show');
            Route::get('create/client/tickets',[\Modules\User\Http\Controllers\Front\ProfileController::class,'createTicket'])->name('client.tickets.create');
            Route::post('store/client/tickets',[\Modules\User\Http\Controllers\Front\ProfileController::class,'storeTicket'])->name('client.tickets.store');
             Route::post('ticket-answer/{id}',[\Modules\User\Http\Controllers\Front\ProfileController::class,'clientTicketStore'])->name('client-ticket-store');



//          addresses

            Route::get('/user-addresses', [AddressController::class, 'index'])->name('user-addresses.index');
            Route::get('/user-addresses/create', [AddressController::class, 'create'])->name('user-addresses.create');
            Route::post('/user-addresses', [AddressController::class, 'store'])->name('user-addresses.store');
            Route::get('/user-addresses/{id}', [AddressController::class, 'show'])->name('user-addresses.show');
            Route::get('/user-addresses/{id}/edit', [AddressController::class, 'edit'])->name('user-addresses.edit');
            Route::put('/user-addresses/{id}', [AddressController::class, 'update'])->name('user-addresses.update');
            Route::delete('/user-addresses/{id}', [AddressController::class, 'destroy'])->name('user-addresses.destroy');

            Route::get('wallet-pay-form' , [\Modules\User\Http\Controllers\Front\WalletController::class , 'WalletPayForm'])->name('wallet-pay-form');
            Route::post('wallet-pay-submit' , [\Modules\User\Http\Controllers\Front\WalletController::class , 'walletPaySubmit'])->name('wallet-pay-submit');

        });
        //          login and register
        Route::get('login-register', [LoginRegisterController::class, 'loginRegisterForm'])->name('auth.customer.login-register-form');
        Route::middleware('throttle:customer-login-register-limiter')->post('/login-register', [LoginRegisterController::class, 'loginRegister'])->name('auth.customer.login-register');
        Route::get('login-confirm', [LoginRegisterController::class, 'loginConfirmForm'])->name('auth.customer.login-confirm-form');
        Route::middleware('throttle:customer-login-confirm-limiter')->post('/login-confirm', [LoginRegisterController::class, 'loginConfirm'])->name('auth.customer.login-confirm');
        Route::middleware('throttle:customer-login-resend-otp-limiter')->post('/login-resend-otp', [LoginRegisterController::class, 'loginResendOtp'])->name('auth.customer.login-resend-otp');

        //        NewsletterSubscription
        Route::post('/newsletter-subscriptions', [NewsletterSubscriptionController::class, 'store'])->name('newsletter-subscriptions.store');


    });

});
