<?php

namespace Modules\Shop\Block\ProductCategory;

use Modules\Core\Block\BlockInterface;
use Modules\Core\Entities\RouteBlockItem;
use Modules\Shop\Entities\ProductCatalogCategory;

class ProductCategoryBlock implements BlockInterface
{
    public $routeBlockConfig =[];
    public $title = 'دسته بندی محصول';
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

        $categories = ProductCatalogCategory::query()->whereNull('parent_id')->limit('6')->get();
        $template = @ $this->routeBlockConfig->template ?? 'simple';
        return view('shop::theme_master.blocks.productCategory.'.$template , compact('block' ,'item_obj' ,'block_obj' , 'categories'));
    }

    public function renderAdmin()
    {
        $item_obj = $this->getBlockRouteItemObject();
        $block_obj = $this->getBlockRouteItemObject();
        $this->routeBlockConfig = $item_obj->configJson;
        $block = $this;
        return view('shop::theme_admin.blocks.productCategory.p_category_block_form' , compact('block' ,'item_obj' ,'block_obj'));
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
            $config = $model->config ? json_decode($model->config) : new \stdClass();
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
