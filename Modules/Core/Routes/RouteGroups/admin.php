<?php
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\SitemapGenerator;

Route::prefix('admin')->name('admin.')->middleware(['web','admin','auth'])->group(function() {
    Route::get('/', [\Modules\Core\Http\Controllers\Admin\AdminController::class , 'index'])->name('index');


    Route::get('generateSiteMap',function (){
        SitemapGenerator::create(url('/'))->writeToFile(public_path('sitemap.xml'));
        return 'done';
    });

    Route::prefix('core')->name('core.')->group(function (){

        Route::get('/file-manager', [\Modules\Core\Http\Controllers\Admin\AdminController::class , 'fileManager'])->name('file-manager-f');
        // *****  setting  ***** //
        Route::prefix('setting')->name('setting.')->group(function (){
            Route::get('/main-setting', [\Modules\Core\Http\Controllers\Admin\setting\SettingController::class , 'mainSettingForm'])->name('main-setting');
            Route::post('/main-setting', [\Modules\Core\Http\Controllers\Admin\setting\SettingController::class , 'mainSettingSave'])->name('main-setting-save');
        });

        // *****  blocks  ***** //

        Route::prefix('blocks')->name('blocks.')->group(function (){
            Route::get('/sub/add-block-to-route-block', [\Modules\Core\Http\Controllers\Admin\block\BlockController::class , 'addBlockToRouteBlock'])->name('add-block-to-route-block');
            Route::post('/sub/update-route-block-item-config', [\Modules\Core\Http\Controllers\Admin\block\BlockController::class , 'updateRouteBlockItemConfig'])->name('update-route-block-item-config');
            Route::get('/sub/remove-route-block-item', [\Modules\Core\Http\Controllers\Admin\block\BlockController::class , 'removeRouteBlockItem'])->name('remove-route-block-item');
        });
        Route::resource('blocks', \Modules\Core\Http\Controllers\Admin\block\BlockController::class );


        // *****  sliders  ***** //
        Route::resource('sliders', \Modules\Core\Http\Controllers\Admin\slider\SliderController::class );

        // *****  menus  ***** //
        Route::resource('menus', \Modules\Core\Http\Controllers\Admin\menu\MenuController::class );


        // *****  drop zone  ***** //
        Route::prefix('dropzone')->name('dropzone.')->group(function (){
            Route::get('/upload', [\Modules\Core\Http\Controllers\Admin\dropzone\DropZoneController::class , 'upload'])->name('upload');
            Route::get('/remove-image/{id}', [\Modules\Core\Http\Controllers\Admin\dropzone\DropZoneController::class , 'remove'])->name('remove');

//            Route::post('/main-setting', [\Modules\Core\Http\Controllers\Admin\setting\SettingController::class , 'mainSettingSave'])->name('main-setting-save');
        });

        // *****  comments  ***** //
        Route::prefix('comments')->name('comments.')->group(function (){
            Route::get('/index-product', [\Modules\Core\Http\Controllers\Admin\comments\CommentController::class, 'index'])->name('index');
            Route::get('/index-post', [\Modules\Core\Http\Controllers\Admin\comments\CommentController::class, 'index'])->name('index-post');
            Route::get('/approve/{id}', [\Modules\Core\Http\Controllers\Admin\comments\CommentController::class, 'approve'])->name('approve');
            Route::get('/update/{id}', [\Modules\Core\Http\Controllers\Admin\comments\CommentController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [\Modules\Core\Http\Controllers\Admin\comments\CommentController::class, 'destroy'])->name('destroy');
        });

        // *****  states  ***** //
        Route::prefix('states')->name('state.')->group(function (){
            Route::get('/index', [\Modules\Core\Http\Controllers\Admin\state\StateController::class, 'index'])->name('index');
            Route::get('/create', [\Modules\Core\Http\Controllers\Admin\state\StateController::class, 'create'])->name('index-post');
            Route::get('/store', [\Modules\Core\Http\Controllers\Admin\state\StateController::class, 'store'])->name('index-post');
            Route::get('/update/{id}', [\Modules\Core\Http\Controllers\Admin\state\StateController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [\Modules\Core\Http\Controllers\Admin\state\StateController::class, 'destroy'])->name('destroy');
        });

        // *****  exports  ***** //
        Route::prefix('exports')->name('exports.')->group(function (){
            Route::get('/', [\Modules\Core\Http\Controllers\Admin\export\ExportController::class, 'export'])->name('export');
            Route::post('/import', [\Modules\Core\Http\Controllers\Admin\export\ExportController::class, 'import'])->name('import');
        });

        // *****  error  ***** //
        Route::prefix('errors')->name('errors.')->group(function (){
            Route::get('/resolve', [\Modules\Core\Http\Controllers\Admin\export\ExportController::class, 'resolve'])->name('resolve');
        });

    });

});
