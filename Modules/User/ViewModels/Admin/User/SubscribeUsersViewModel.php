<?php

namespace Modules\User\ViewModels\Admin\User;

use App\Models\User;
use Modules\Core\Trait\GridTrait;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\User\Entities\NewsletterSubscription;

class SubscribeUsersViewModel extends BaseViewModel
{
    use GridTrait;
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function setGridData()
    {
        $query = NewsletterSubscription::query();
        $this->rows = $query->paginate(40);
        return $this;
    }
    public function setColumns()
    {

        $this->addColumn([
            'name'=>'email',
            'title'=>'ایمیل',
        ]);

        $this->addColumn([
            'name'=>'is_subscribed',
            'title'=>'وضعیت عضویت',
        ]);
        return $this;
    }

    public function getRowUpdate($row)
    {
        $row->avatar = $row->avatar ? '<img src="'.url($row->avatar).'" style="width: 100px">' : '';
        $row->is_subscribed = $row->is_subscribed ==1 ? 'فعال' : 'غیر فعال';
        return $row;
    }

    public function showGrid()
    {
        $this->add_new_link = route('admin.core.sliders.create');
        return $this->setGridData()->setColumns()->renderGridView();
    }

}
