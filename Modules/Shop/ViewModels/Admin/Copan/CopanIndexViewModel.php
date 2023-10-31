<?php

namespace Modules\Shop\ViewModels\Admin\Copan;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\Blog\Entities\Post;
use Modules\Core\Entities\Comment;
use Modules\Core\Entities\RouteBlock;
use Modules\Core\Trait\GridTrait;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\Copan;
use Modules\Shop\Entities\ProductCatalog;

class CopanIndexViewModel extends BaseViewModel
{
    public function index()
    {
        try {
            DB::beginTransaction();
        } catch (\Exception $exception) {
            DB::rollBack();
            alert()->error('مشکلی پیش آمده است');
            Log::critical($exception->getMessage());
            return redirect()->back();
        }
        DB::commit();
        alert()->success('با موفقیت انجام شد');
        return redirect()->back();
    }
    use GridTrait;

    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function setGridData()
    {
        $this->rows = Copan::paginate(40);
        return $this;
    }

    public function setColumns()
    {

        $this->addColumn([
            'name' => 'code',
            'title' => 'کد',
        ]);

        $this->addColumn([
            'name' => 'amount',
            'title' => 'درصد',
        ]);
        $this->addColumn([
            'name' => 'start_date',
            'title' => 'تاریخ فعال شدن',
        ]);
        $this->addColumn([
            'name' => 'end_date',
            'title' => 'تاریخ پایان اعتبار',
        ]);
        $this->addColumn([
            'name' => 'allowed_number_of_uses',
            'title' => 'تعداد مجاز استفاده',
        ]);
        $this->addColumn([
            'name' => 'first_buy',
            'title' => 'فقط سفارش اول',
        ]);
        /*** actions ***/
        $this->addAction([
            'name' => 'remove',
            'title' => 'حذف',
            'url' => array(
                'name' => 'admin.shop.copan.destroy',
                'parameter' => ['id'],
                'method' => 'delete',
            ),
            'class' => 'btn-warning',
        ]);
        return $this;
    }

    public function getRowUpdate($row)
    {
        $row->first_buy = $row->first_buy===1 ? 'بلی' : 'خیر';
        $row->start_date = jdate( $row->start_date )->format('Y/m/d');
        $row->end_date = jdate( $row->end_date )->format('Y/m/d');
        return $row;
    }

    public function showGrid()
    {
        return $this->setGridData()->setColumns()->renderGridView();
    }
}
