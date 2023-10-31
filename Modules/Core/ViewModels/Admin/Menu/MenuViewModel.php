<?php

namespace Modules\Core\ViewModels\Admin\Menu;

use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;
use Modules\Core\Entities\Menu;
use Modules\Core\Entities\Slider;
use Modules\Core\Trait\GridTrait;
use Modules\Core\ViewModels\BaseViewModel;
use function Modules\Blog\ViewModels\Admin\Post\mb_substr;

class MenuViewModel extends BaseViewModel
{
    use GridTrait;
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function setGridData()
    {
        $query = Menu::query();

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
            'name'=>'link',
            'title'=>'لینک',
        ]);

        $this->addColumn([
            'name'=>'parent',
            'title'=>'والد',
        ]);

        $this->addColumn([
            'name'=>'child_count',
            'title'=>'تعداد زیر مجموعه ها',
        ]);


        /*** actions ***/
        $this->addAction([
            'name'=>'edit',
            'title'=>'ویرایش',
            'url'=>array(
                'name' => 'admin.core.menus.edit',
                'parameter' => ['id'],
                'method' => 'get',
            ),
            'class'=>'btn-warning',
        ]);

        $this->addAction([
            'name'=>'remove',
            'title'=>'حذف',
            'url'=>array(
                'name' => 'admin.core.menus.destroy',
                'parameter' => ['id'],
                'method' => 'delete',
            ),
            'class'=>'btn-danger',
        ]);


        /*** buttons ***/
        $this->addButton([
            'name'=>'addNew',
            'title'=>'افزودن جدید',
            'url'=>route('admin.core.menus.create'),
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
        $row->child_count =  $row->childs->count() ;
        $row->parent =  $row->parent->title ?? '-' ;

        return $row;
    }
    public function showGrid()
    {
        return $this->setGridData()->setColumns()->renderGridView();
    }

}
