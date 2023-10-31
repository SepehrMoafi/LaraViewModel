<?php
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['web','admin','auth'])->group(function() {

    Route::prefix('user')->name('user.')->group(function (){

        // *****  users  ***** //
        Route::resource('users', \Modules\User\Http\Controllers\Admin\Users\UsersController::class );

        Route::resource('users-company', \Modules\User\Http\Controllers\Admin\Users\UsersCompanyController::class );

        Route::get('visitors-static', [\Modules\User\Http\Controllers\Admin\Users\VisitorStatisticsController::class,'index'] )->name('statistics-visitor.index');

        Route::get('user/wallet/{id}' , [\Modules\User\Http\Controllers\Admin\Users\UsersController::class , 'showWallet'])->name('user-wallet');

        Route::get('subscribe-users',[\Modules\User\Http\Controllers\Admin\Users\SubscribeUsersController::class,'index'])->name('subscribe-users.index');

        Route::resource('tickets', \Modules\User\Http\Controllers\Admin\Tickets\TicketController::class );
        Route::resource('departments', \Modules\User\Http\Controllers\Admin\Departments\DepartmentsController::class );

        Route::prefix('ticket-answer')->name('ticket_answer.')->group(function() {
            Route::post('/{id}',[\Modules\User\Http\Controllers\Admin\Tickets\TicketAnswerController::class,'store'])->name('store');
        });

        Route::get('send-sms',[\Modules\User\Http\Controllers\Admin\Users\SendSmsController::class,'index'])->name('send-sms.index');

        Route::post('send-sms',[\Modules\User\Http\Controllers\Admin\Users\SendSmsController::class,'sendSms'])->name('send-sms');
    });

});
