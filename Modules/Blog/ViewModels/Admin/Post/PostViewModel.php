<?php

namespace Modules\Blog\ViewModels\Admin\Post;

use Modules\Blog\Entities\Post;
use Modules\Core\Entities\Slider;
use Modules\Core\Trait\GridTrait;
use Modules\Core\ViewModels\BaseViewModel;

class PostViewModel extends BaseViewModel
{
    use GridTrait;
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function setGridData()
    {
        $query = Post::query();

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
            'name'=>'status',
            'title'=>'وضعیت',
        ]);

        $this->addColumn([
            'name'=>'description',
            'title'=>'خلاصه',
        ]);

        /*** actions ***/
        $this->addAction([
            'name'=>'edit',
            'title'=>'ویرایش',
            'url'=>array(
                'name' => 'admin.blog.posts.edit',
                'parameter' => ['id'],
                'method' => 'get',
            ),
            'class'=>'btn-warning',
        ]);

        $this->addAction([
            'name'=>'remove',
            'title'=>'حذف',
            'url'=>array(
                'name' => 'admin.blog.posts.destroy',
                'parameter' => ['id'],
                'method' => 'delete',
            ),
            'class'=>'btn-danger',
        ]);


        /*** buttons ***/
        $this->addButton([
            'name'=>'addNew',
            'title'=>'افزودن جدید',
            'url'=>route('admin.blog.posts.create'),
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
        $row->status = $row->status == 1 ? 'منتشر شده' : 'پیش نویس';
        $row->description = mb_substr( $row->description , 0 , 20).' ...' ;

        return $row;
    }
    public function showGrid()
    {
        $this->add_new_link = route('admin.core.sliders.create');
        return $this->setGridData()->setColumns()->renderGridView();
    }

}
