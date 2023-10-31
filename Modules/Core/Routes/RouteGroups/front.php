<?php
use Illuminate\Support\Facades\Route;


Route::name('front.')->middleware(['web'])->group(function() {

    Route::get('/', [\Modules\Core\Http\Controllers\Front\FrontController::class , 'index']);
    Route::post('comment',[\Modules\Core\Http\Controllers\Admin\comments\CommentController::class,'store'])->name('comment.store');

    Route::get('/contact', [\Modules\Core\Http\Controllers\Front\FrontController::class , 'contact'])->name('contact');
    Route::get('/about', [\Modules\Core\Http\Controllers\Front\FrontController::class , 'about'])->name('about');

    Route::get('/by-form', [\Modules\Core\Http\Controllers\Front\FrontController::class , 'byForm'])->name('by-form');
    Route::get('/faq', [\Modules\Core\Http\Controllers\Front\FrontController::class , 'faq'])->name('faq');
    Route::get('/send_type', [\Modules\Core\Http\Controllers\Front\FrontController::class , 'send_type'])->name('send_type');
    Route::get('/rule', [\Modules\Core\Http\Controllers\Front\FrontController::class , 'rule'])->name('rule');
    Route::get('/rollback', [\Modules\Core\Http\Controllers\Front\FrontController::class , 'rollback'])->name('rollback');

    Route::post('/form', [\Modules\Core\Http\Controllers\Front\FormController::class , 'store'])->name('form.store');

    Route::get('/page/{name}', [\Modules\Core\Http\Controllers\Front\FrontController::class , 'showPage'])->name('page');
});
