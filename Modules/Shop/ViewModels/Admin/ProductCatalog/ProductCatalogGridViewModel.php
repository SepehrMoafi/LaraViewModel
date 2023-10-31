<?php

namespace Modules\Shop\ViewModels\Admin\ProductCatalog;

use App\Models\User;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;
use Modules\Core\Entities\Slider;
use Modules\Core\Trait\GridTrait;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\Brand;
use Modules\Shop\Entities\ProductCatalog;
use Modules\Shop\Entities\ProductCatalogCategory;
use Modules\User\Entities\VisitorStatistics;

class ProductCatalogGridViewModel extends BaseViewModel
{
    use GridTrait;
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function setGridData()
    {
        $query = ProductCatalog::query();

        if ( request('title') ){
            $query->where('title' , 'like' , '%' . request('title') . '%');
        }

        if (request('brand_id')){
            $query->where('brand_id' , request('brand_id'));
        }

        if (request('category_id')){
            $query->whereHas( 'categories' , function ($q) {
                $cat_f[request('category_id')] = request('category_id');
                foreach ($cat_f as $key => $item) {
                    $q->where('category_id' , $item);
                }
            });
        }

        $this->rows = $query->paginate(40);
        return $this;
    }
    public function setColumns()
    {
        $this->addColumn([
            'name'=>'image',
            'title'=>'تصویر',
        ]);

        $this->addColumn([
            'name'=>'title',
            'title'=>'عنوان	',
        ]);
        $this->addColumn([
            'name'=>'clickCount',
            'title'=>'تعداد کلیک',
        ]);
        $this->addColumn([
            'name'=>'en_title',
            'title'=>'عنوان لاتین',
        ]);

        /*** actions ***/
        $this->addAction([
            'name'=>'edit',
            'title'=>'ویرایش',
            'url'=>array(
                'name' => 'admin.shop.product-catalog.edit',
                'parameter' => ['id'],
                'method' => 'get',
            ),
            'class'=>'btn-warning',
        ]);

        $this->addAction([
            'name'=>'remove',
            'title'=>'حذف',
            'url'=>array(
                'name' => 'admin.shop.product-catalog.destroy',
                'parameter' => ['id'],
                'method' => 'delete',
            ),
            'class'=>'btn-danger',
        ]);


        /*** buttons ***/

        $this->addButton([
            'name' => 'addNew',
            'title' => 'افزودن جدید',
            'url' => route('admin.shop.product-catalog.create'),
            'class' => 'btn-warning',
        ]);

        /*** filters ***/
        $this->addFilter([
            'name'=>'title',
            'title'=>'عنوان',
            'type'=>'text',
        ]);

//        $this->addFilter([
//            'name'=>'en_title',
//            'title'=>'عنوان',
//            'type'=>'text',
//        ]);
//
//        $this->addFilter([
//            'name'=>'2nd_title',
//            'title'=>'عنوان',
//            'type'=>'text',
//        ]);

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


        return $this;
    }

    public function getRowUpdate($row)
    {
        $row->image = $row->image ? '<img src="'.url($row->image).'" style="width: 100px">' : '';
        $row->clickCount = $row->click_count;
        return $row;
    }

    public function showGrid()
    {
        return $this->setGridData()->setColumns()->renderGridView();
    }

}
