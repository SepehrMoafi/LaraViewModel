<?php

namespace Modules\Shop\ViewModels\Front\Product;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;
use Modules\Blog\Entities\PostCategoryRelation;
use Modules\Blog\Entities\postRelation;
use Modules\Blog\Entities\PostTag;
use Modules\Blog\Entities\PostTagRelation;
use Modules\Core\Entities\Comment;
use Modules\Core\Http\Controllers\Admin\dropzone\DropZoneController;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\Attribute;
use Modules\Shop\Entities\Brand;
use Modules\Shop\Entities\Product;
use Modules\Shop\Entities\ProductCatalog;
use Modules\Shop\Entities\ProductCatalogCategory;
use Modules\Shop\Entities\ProductCatalogCategoryRel;
use Modules\Shop\Entities\ProductCatalogRel;
use Modules\Shop\Entities\ProductCatalogRelAccessory;
use Morilog\Jalali\Jalalian;
use function Psy\debug;

class ProductViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_master';
    }

    public function index()
    {
        $products = ProductCatalog::query();

        if (request('just_active') == 'on'){
            $products->where('out_of_sell' , 0)
                ->where('is_active' , 1 )
                ->whereHas('products' , function ($q){
                    $q->where('qty' , '>=' , 0);
                });
        }

        if (request('price_from')){
            $products->whereHas('products' , function ($q){
                $q->where('price' , '>' , request('price_from') );
            });
        }
        if (request('title')){
            $products->whereHas('products' , function ($q){
                $q->where('title' , 'like' , '%'.request('title').'%' );
            });
        }

        if (request('price_to')){
            $products->whereHas('products' , function ($q){
                $q->where('price' , '<=' , request('price_to') );
            });
        }

        if (request('brand')){
            $brand_f = array_keys(request('brand'));
            $products->whereIn('brand_id' , $brand_f);
        }

        if (request('category')){
            $cat_f = array_keys(request('category'));
            $products->whereHas( 'categories' , function ($q) use($cat_f){
                foreach ($cat_f as $key => $item) {
                    if ($key == 0){
                        $q->where('category_id' , $item);
                    }else{
                        $q->orWhere('category_id' , $item);
                    }
                }
            });
        }

        if (request('attrs')){
            $products = $products->whereHas('attributes' , function ($q){
                $cc= 0;
                foreach (request('attrs') as $attr_id => $attr_val_array ){
                    if ($cc == 0){
                        $q->where('attribute_id' ,$attr_id )->where( function ($qa) use ($attr_val_array){
                            $count = 0;
                            foreach ($attr_val_array as $val_id => $item5) {
                                if ($count == 0){
                                    $qa->where('value_id' , $val_id);
                                }else{
                                    $qa->orWhere('value_id' , $val_id);
                                }
                                $count ++ ;
                            }
                        } );
                    }else{
                        $q->orWhere('attribute_id' ,$attr_id )->where( function ($qa) use ($attr_val_array){
                            $count = 0;
                            foreach ($attr_val_array as $val_id => $item5) {
                                if ($count == 0){
                                    $qa->where('value_id' , $val_id);
                                }else{
                                    $qa->orWhere('value_id' , $val_id);
                                }
                                $count ++ ;
                            }
                        } );
                    }
                    $cc ++ ;

                }

            });
        }

        if (request('sort_type') == 1){
            $products = $products->join('products' , 'products.product_catalog_id' , '=' ,'product_catalogs.id' )
                ->orderBy('products.price', 'desc')->select('product_catalogs.*');
        }elseif (request('sort_type') == 2){
            $products = $products->join('products' , 'products.product_catalog_id' , '=' ,'product_catalogs.id' )
                ->orderBy('products.price', 'asc')->select('product_catalogs.*');
        }elseif (request('sort_type') == 3){
            $products = $products->join('products' , 'products.product_catalog_id' , '=' ,'product_catalogs.id' )
                ->orderBy('products.created_at', 'desc')->select('product_catalogs.*');
        }elseif (request('sort_type') == 4){
            // TODO sort by orders
        }else{

        }
        $products = $products->paginate(30);

        $brands = Brand::query()->get();
        $categories = ProductCatalogCategory::query()->get();
        $atters = Attribute::query()->where('params->for_filter' , 1)->get();


        $data = [
            'view_model' => $this,
            'products' => $products,
            'brands' => $brands,
            'categories' => $categories,
            'atters' => $atters,
        ];
        return $this->renderView('shop::product.archive_products' ,$data);
    }
    public function show($request)
    {
        $this->modelData = ProductCatalog::findOrFail( $request->model_id );
        $data = [
            'view_model' => $this,
            'product' => $this->modelData,
            'comments' => $this->modelData->comments->where('approve',true),
        ];

        return $this->renderView('shop::product.show_product' ,$data);
    }

}
