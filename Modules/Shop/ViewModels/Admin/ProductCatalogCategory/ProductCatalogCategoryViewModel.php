<?php

namespace Modules\Shop\ViewModels\Admin\ProductCatalogCategory;

use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;
use Modules\Core\Entities\Slider;
use Modules\Core\Trait\GridTrait;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\ProductCatalogCategory;
use function Modules\Blog\ViewModels\Admin\Post\mb_substr;

class ProductCatalogCategoryViewModel extends BaseViewModel
{
    use GridTrait;
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function setGridData()
    {
        $query = ProductCatalogCategory::query();

        if ( request('title') ){
            $query->where('title' , 'like' , '%' . request('title') . '%');
        }

        $this->rows = $query->paginate(40);
        return $this;
    }
    public function setColumns()
    {
        $this->addColumn([
            'name'=>'title',
            'title'=>'عنوان',
        ]);
        $this->addColumn([
            'name'=>'image',
            'title'=>'تصویر',
        ]);
        $this->addColumn([
            'name'=>'parent',
            'title'=>'والد',
        ]);

        $this->addColumn([
            'name'=>'child_count',
            'title'=>'تعداد زیر مجموعه ها',
        ]);

        $this->addColumn([
            'name'=>'description',
            'title'=>'توضیح',
        ]);

        /*** actions ***/
        $this->addAction([
            'name'=>'edit',
            'title'=>'ویرایش',
            'url'=>array(
                'name' => 'admin.shop.product-catalog-category.edit',
                'parameter' => ['id'],
                'method' => 'get',
            ),
            'class'=>'btn-warning',
        ]);

        $this->addAction([
            'name'=>'remove',
            'title'=>'حذف',
            'url'=>array(
                'name' => 'admin.shop.product-catalog-category.destroy',
                'parameter' => ['id'],
                'method' => 'delete',
            ),
            'class'=>'btn-danger',
        ]);


        /*** buttons ***/
        $this->addButton([
            'name'=>'addNew',
            'title'=>'افزودن جدید',
            'url'=>route('admin.shop.product-catalog-category.create'),
            'class'=>'btn-primary',
        ]);

        /*** filters ***/
        $this->addFilter([
            'name'=>'title',
            'title'=>'عنوان',
            'type'=>'text',
        ]);




        return $this;
    }

    public function getRowUpdate($row)
    {
        $row->image = $row->image ? '<img src="'.url($row->image)  .'" style="width: 100px">' : '';
        $row->description = \mb_substr( $row->description , 0 , 20).' ...' ;
        $row->child_count =  $row->childs->count() ;
        $row->parent =  $row->parent->title ?? '-' ;

        return $row;
    }
    public function showGrid()
    {
        return $this->setGridData()->setColumns()->renderGridView();
    }

}
