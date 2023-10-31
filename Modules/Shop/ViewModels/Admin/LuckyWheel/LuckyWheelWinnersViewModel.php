<?php

namespace Modules\Shop\ViewModels\Admin\LuckyWheel;

use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Trait\GridTrait;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\UserGift;

class LuckyWheelWinnersViewModel extends BaseViewModel
{
    use GridTrait;

    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function setGridData($is_export = false)
    {
        $query = UserGift::query();
        if ($is_export) {
            $this->rows = $query;
        } else {
            $this->rows = $query->paginate(40);
        }
        return $this;
    }

    public function setColumns()
    {
        $this->addColumn([
            'name' => 'user_id',
            'title' => 'کاربر برنده',
        ]);

        $this->addColumn([
            'name' => 'gift_item_id',
            'title' => 'آیتمی که برنده شده است',
        ]);

        $this->addColumn([
            'name' => 'gift_id',
            'title' => 'آیتمی که گردانه برای آن درست شده',
        ]);
        $this->can_export = true;
        return $this;
    }

    public function getRowUpdate($row)
    {
        $row->gift_id = $row->gift->productCatalog->title ;
        $row->user_id = $row->user->name;
        $row->gift_item_id = $row->giftItem->itemable->title ?? " کد تخفیف {$row->giftItem->itemable->amount} درصدی";
        return $row;
    }

    public function getActionUpdate($actions, $row)
    {
        return $actions;
    }

    public function showGrid()
    {
        return $this->setGridData()->setColumns()->renderGridView();
    }
}
