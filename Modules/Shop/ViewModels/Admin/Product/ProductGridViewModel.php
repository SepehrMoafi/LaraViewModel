<?php

namespace Modules\Shop\ViewModels\Admin\Product;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;
use Modules\Core\Entities\Slider;
use Modules\Core\Service\Finance\TarazService;
use Modules\Core\Trait\GridTrait;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\Brand;
use Modules\Shop\Entities\Product;
use Modules\Shop\Entities\ProductCatalog;
use Modules\Shop\Entities\ProductCatalogCategory;

class  ProductGridViewModel extends BaseViewModel
{
    use GridTrait;
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function setGridData($is_export = false)
    {
        $query = Product::query();

        if ( request('title') ){
            $query->where('good_info->goodsDesc' , 'like' , '%' . request('title') . '%');
        }

        if (request('brand_id')){
            $query->whereHas('catalog' , function ($q){
                $q->where('brand_id' , request('brand_id'));
            });
        }

        if (request('category_id')){

            $query->whereHas('catalog' , function ($q){
                $q->whereHas( 'categories' , function ($q) {
                    $cat_f[request('category_id')] = request('category_id');
                    foreach ($cat_f as $key => $item) {
                        $q->where('category_id' , $item);
                    }
                });
            });

        }



        if ($is_export){
            $this->rows = $query;
        }else{
            $this->rows = $query->paginate(40);
        }

        return $this;
    }

    public function setColumns()
    {
        $this->addColumn([
            'name'=>'title',
            'title'=>'عنوان کاتالوگ	',
        ]);
        $this->addColumn([
            'name'=>'en_title',
            'title'=>'عنوان	',
        ]);
        $this->addColumn([
            'name'=>'color',
            'title'=>'رنگ',
        ]);

        $this->addColumn([
            'name'=>'price',
            'title'=>'قیمت',
        ]);

        $this->addColumn([
            'name'=>'qty',
            'title'=>'تعداد',
        ]);

        $this->addColumn([
            'name'=>'wight',
            'title'=>'وزن',
        ]);

        /*** actions ***/
        $this->addAction([
            'name'=>'edit',
            'title'=>'ویرایش',
            'url'=>array(
                'name' => 'admin.shop.product.edit',
                'parameter' => ['id'],
                'method' => 'get',
            ),
            'class'=>'btn-warning',
        ]);

        $this->addAction([
            'name'=>'remove',
            'title'=>'حذف',
            'url'=>array(
                'name' => 'admin.shop.product.destroy',
                'parameter' => ['id'],
                'method' => 'delete',
            ),
            'class'=>'btn-danger',
        ]);


        /*** buttons ***/


//        $this->addButton([
//            'name' => 'addNew',
//            'title' => 'افزودن جدید',
//            'url' => route('admin.shop.product.create'),
//            'class' => 'btn-warning',
//        ]);

        $this->addButton([
            'name' => 'UpdateTaraz',
            'title' => 'آپدیت تراز',
            'url' => route('admin.shop.product.update-taraz'),
            'class' => 'btn-success',
        ]);

        /*** filters ***/
        $this->addFilter([
            'name'=>'title',
            'title'=>'عنوان',
            'type'=>'text',
        ]);

        $brands = Brand::query()->pluck('title' , 'id')->toArray();
        $this->addFilter([
            'name'=>'brand_id',
            'title'=>'برند',
            'type'=>'select',
            'options' => $brands
        ]);

        $cats = ProductCatalogCategory::query()->pluck('title' , 'id')->toArray();
        $this->addFilter([
            'name'=>'category_id',
            'title'=>'دسته بندی',
            'type'=>'select',
            'options' => $cats
        ]);


        $this->can_export = true;

        return $this;
    }

    public function getRowUpdate($row)
    {
        $row->color = $row->color ? '<div class="badge" style="height: 25px;
        width: 25px;
        border-radius: 100%;background:'.$row->color.'">' : '';

        $row->title = @ $row->catalog->title ?? 'انتخاب نشده';

        $row->en_title = @ $row->good_info_json->goodsDesc ?? '';
        return $row;
    }

    public function showGrid()
    {
        return $this->setGridData()->setColumns()->renderGridView();
    }



    public function getRowExportUpdate($row)
    {
        $res = new Collection(
            [
                'title'=>@ $row->catalog->title ?? '',
                'en_title'=>@ $row->good_info_json->goodsDesc ?? '',
                'price'=>@ $row->price ?? '0',
                'qty'=>@ $row->qty ?? '0',
                'wight'=>@ $row->wight ?? '0',
            ]
        );
        return $res;
    }

}
