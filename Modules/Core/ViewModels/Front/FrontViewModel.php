<?php

namespace Modules\Core\ViewModels\Front;

use Illuminate\Support\Facades\Artisan;
use Modules\Blog\Entities\Post;
use Modules\Core\Entities\RouteBlock;
use Modules\Core\Entities\Slider;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\ProductCatalog;
use Modules\Shop\Entities\ProductCatalogCategory;
use Modules\User\Trait\authTaraz;

class FrontViewModel extends BaseViewModel
{
    use authTaraz;
    public function __construct()
    {
        $this->theme_name = 'theme_master';
    }

    public function index()
    {
        //Artisan::call('cache:clear');
        //Artisan::call('storage:link');
        //Artisan::call('migrate');
        $route_block = RouteBlock::where('route_name' , 'front.core.index')->first();

        //$this->registerCustomer( request()->toArray() );

        return $this->renderView('core::index' , [
            'route_block'=> $route_block ,
        ]);
    }

    public function contact()
    {
        $route_block = RouteBlock::where('route_name' , 'front.core.contact')->first();

        return $this->renderView('core::index' , [
            'route_block'=> $route_block ,
        ]);
    }
    public function about()
    {
        $route_block = RouteBlock::where('route_name' , 'front.core.about')->first();

        return $this->renderView('core::index' , [
            'route_block'=> $route_block ,
        ]);
    }

    public function showPage($request)
    {
        $route_block = RouteBlock::where('route_name' , request()->get('page') )->first();

        if (! $route_block){
            abort(404);
        }

        return $this->renderView('core::page' , [
            'route_block'=> $route_block ,
        ]);

    }
}
