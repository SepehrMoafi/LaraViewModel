<?php

namespace Modules\User\ViewModels\Admin\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;
use Modules\Core\Entities\Slider;
use Modules\Core\Trait\GridTrait;
use Modules\Core\ViewModels\BaseViewModel;
class UserGridViewModel extends BaseViewModel
{
    use GridTrait;
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function setGridData($is_export = false)
    {
        $query = User::query();
        if ( request('title') ){
            $query->where('title' , 'like' , '%' . request('title') . '%');
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
            'name'=>'avatar',
            'title'=>'تصویر',
        ]);

        $this->addColumn([
            'name'=>'name',
            'title'=>'نام و نام‌خانوادگی	',
        ]);
        $this->addColumn([
            'name'=>'email',
            'title'=>'ایمیل',
        ]);

        $this->addColumn([
            'name'=>'mobile',
            'title'=>'شماره تماس',
        ]);

        $this->addColumn([
            'name'=>'date_last_order',
            'title'=>'تاریخ آخرین سفارش ',
        ]);

        $this->addColumn([
            'name'=>'created_at',
            'title'=>'تاریخ ایجاد حساب 	 ',
        ]);

        $this->addColumn([
            'name'=>'order_count',
            'title'=>'تعداد سفارشات	',
        ]);

        $this->addColumn([
            'name'=>'amount',
            'title'=>'کیف پول',
        ]);

        /*** actions ***/
        $this->addAction([
            'name'=>'edit',
            'title'=>'ویرایش',
            'url'=>array(
                'name' => 'admin.user.users.edit',
                'parameter' => ['id'],
                'method' => 'get',
            ),
            'class'=>'btn-warning',
        ]);

        $this->addAction([
            'name'=>'remove',
            'title'=>'حذف',
            'url'=>array(
                'name' => 'admin.blog.post-category.destroy',
                'parameter' => ['id'],
                'method' => 'delete',
            ),
            'class'=>'btn-danger',
        ]);


        /*** buttons ***/


        /*** filters ***/
        $this->addFilter([
            'name'=>'title',
            'title'=>'عنوان',
            'type'=>'text',
        ]);

        $this->can_export = true;

        return $this;
    }

    public function getRowExportUpdate($row)
    {
        $res = new Collection(
            [
                'id' => $row->id ,
                'name' => $row->name ,
                'email' => $row->email ,
                'mobile' => $row->mobile ,
                'national_code' => $row->national_code ,
                //'type' => $row->type ,
                'created_at' =>  jdate($row->created_at)->format('Y-m-d H:i'),
            ]
        );
        return $res;
    }

    public function getRowUpdate($row)
    {
        $row->avatar = $row->avatar ? '<img src="'.url($row->avatar).'" style="width: 100px">' : '';
        return $row;
    }

    public function showGrid()
    {
        $this->add_new_link = route('admin.core.sliders.create');
        return $this->setGridData()->setColumns()->renderGridView();
    }

}
