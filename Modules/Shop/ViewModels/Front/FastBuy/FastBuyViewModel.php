<?php

namespace Modules\Shop\ViewModels\Front\FastBuy;

use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\Product;
use Modules\Shop\Entities\ProductCatalog;
use Modules\Shop\Entities\ProductCatalogCategory;
use Modules\Shop\ViewModels\Front\Cart\CartViewModel;
use Modules\Shop\ViewModels\Front\Cart\CheckoutViewModel;

class FastBuyViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_master';
    }

    public function index()
    {
        $category = request()->query('category');
        $products = Product::query()->whereHas('catalog');
        $cart = new CartViewModel();
        $cart = $cart->getCart();

        if ($category) {
            $products->whereHas('catalog',function ($q)use($category){
                $q->whereHas('categories',function ($q2)use($category){
                    $q2->where('category_id',$category);
                });
            });
        }

        if (request('qu') && request('qu') != ''){
            $products->whereHas('catalog',function ($q){
                $q->where('title' , 'like' , '%' . request('qu') .'%');
            });
        }

        $products = $products->paginate(50);
        $categories = ProductCatalogCategory::query()->select(['title', 'image', 'id'])->get();
        $data = [
            'view_model' => $this,
            'categories' => $categories,
            'products' => $products,
            'cart' => $cart,
            'view_model2' => new CheckoutViewModel(),
        ];
        return $this->renderView('shop::fastBuy.index', $data);
    }
}
