<?php

namespace Modules\Shop\Block\Products;

use Modules\Core\Block\BlockInterface;
use Modules\Core\Entities\RouteBlockItem;
use Modules\Core\Entities\Slider;
use Modules\Shop\Entities\ProductCatalog;

class ProductBlock implements BlockInterface
{
    public $routeBlockConfig =[];
    public $title = 'نمایش محصول';
    public $block_route_item_id , $route_block_id ;

    public function __construct($block_route_item_id)
    {
        $this->block_route_item_id = $block_route_item_id;
    }
    public function renderFront()
    {
        $item_obj = $this->getBlockRouteItemObject();
        $block_obj = $this->getBlockRouteItemObject();
        $this->routeBlockConfig = $item_obj->configJson;
        $block = $this;
        $c_products = $s_products = [];
        if ( @ $this->routeBlockConfig->products){
            $s_products = ProductCatalog::
                whereIn('id' ,$this->routeBlockConfig->products )
                ->pluck('id') ->toArray();
        }
        if ( @ $this->routeBlockConfig->category){
            $c_products = ProductCatalog::whereHas( 'categories' , function ($q){
                    $q->whereIn('category_id' , $this->routeBlockConfig->category);
                })
                ->pluck('id') ->toArray();
        }
        $products = array_merge($c_products , $s_products );
        if ( count($products ) == 0){
            $products =  ProductCatalog::pluck('id') ->toArray();
        }
        $products = ProductCatalog::whereIn('id' , $products)
            ->limit(10)
            ->latest()
            ->get();
        $template = @ $this->routeBlockConfig->template ?? 'product_slide';
        return view('shop::theme_master.blocks.product.'.$template , compact('block' ,'item_obj' ,'block_obj' , 'products' ));
    }

    public function renderAdmin()
    {
        $item_obj = $this->getBlockRouteItemObject();
        $block_obj = $this->getBlockRouteItemObject();
        $this->routeBlockConfig = $item_obj->configJson;
        $block = $this;
        return view('shop::theme_admin.blocks.product.product_block_form' , compact('block' ,'item_obj' ,'block_obj'));

    }

    public function saveConfig()
    {
        $model = $this->getBlockRouteItemObject();

        if (request('params')){
            $params = $model->params ? json_decode($model->params) : new \stdClass();
            foreach (request('params') as $key => $data){
                $params->$key = $data;
            }
            $model->params = json_encode($params);
        }

        if (request('config')){
            $config = new \stdClass();
            foreach (request('config') as $key => $data){
                $config->$key = $data;
            }
            $model->config = json_encode($config);
        }

        $model->fill( request()->all(['sort']) );

        $model->save();

    }

    public function getBlockRouteItemObject()
    {
        return RouteBlockItem::find($this->block_route_item_id);

    }
}
