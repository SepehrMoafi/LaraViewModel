<?php


use Illuminate\Support\Facades\Route;

Route::name('blog.')->prefix('blog')->middleware(['web'])->group(function () {
    Route::get('/posts', [\Modules\Blog\Http\Controllers\Front\PostController::class, 'index'])->name('index');
    Route::get('/posts/{post:slug}', [\Modules\Blog\Http\Controllers\Front\PostController::class, 'show'])->name('show');
});
