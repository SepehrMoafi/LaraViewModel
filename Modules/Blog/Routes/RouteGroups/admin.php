<?php
use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\Admin\posts\PostController;

Route::prefix('admin')->name('admin.')->middleware(['web','admin','auth'])->group(function() {

    Route::prefix('blog')->name('blog.')->group(function (){

        // *****  posts  ***** //
        Route::resource('posts', PostController::class );

        // *****  posts category ***** //
        Route::resource('post-category', \Modules\Blog\Http\Controllers\Admin\PostCategory\PostCategoryController::class );

        Route::post('storeImageMedia',[PostController::class,'storeImageMedia'])->name('admin.ArticleImage.store');


    });

});
