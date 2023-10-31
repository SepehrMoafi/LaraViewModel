<?php

namespace Modules\Core\ViewModels\Admin\Slider;

use Modules\Core\Entities\Slider;
use Modules\Core\Trait\GridTrait;
use Modules\Core\ViewModels\BaseViewModel;

class SliderViewModel extends BaseViewModel
{
    use GridTrait;
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function setGridData()
    {
        $query = Slider::query();

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
            'name'=>'type',
            'title'=>'حالت نمایش',
        ]);
        $this->addColumn([
            'name'=>'position',
            'title'=>'جایگاه',
        ]);
        $this->addColumn([
            'name'=>'sort',
            'title'=>'مرتب سازی ',
        ]);

        /*** actions ***/
        $this->addAction([
            'name'=>'edit',
            'title'=>'ویرایش',
            'url'=>array(
                'name' => 'admin.core.sliders.edit',
                'parameter' => ['id'],
                'method' => 'get',
            ),
            'class'=>'btn-warning',
        ]);

        /*** buttons ***/
        $this->addButton([
            'name'=>'addNew',
            'title'=>'افزودن جدید',
            'url'=>route('admin.core.sliders.create'),
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
        $row->type = $row->type == 1 ? 'اسلایدر' : 'بنر';

        return $row;
    }
    public function showGrid()
    {
        $this->add_new_link = route('admin.core.sliders.create');
        return $this->setGridData()->setColumns()->renderGridView();
    }

}
