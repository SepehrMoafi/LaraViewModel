<?php

namespace Modules\Shop\ViewModels\Admin\Payment;

use Illuminate\Support\Facades\DB;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;
use Modules\Core\Entities\Slider;
use Modules\Core\Trait\GridTrait;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\Brand;
use Modules\Shop\Entities\Payment;
use Modules\Shop\Entities\Product;
use Modules\Shop\Entities\ProductCatalogCategory;
use Modules\User\Entities\Wallet;
use Modules\User\Entities\WalletTransaction;
use function Modules\Blog\ViewModels\Admin\Post\mb_substr;

class PaymentViewModel extends BaseViewModel
{
    use GridTrait;
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function setGridData()
    {
        $query = Payment::query();

        if ( request('user_name') ){
            $query->whereHas('user' , function ($q){
                $q->where('name' , 'like' , '%' .request('user_name').'%');
            });
        }

        if ( request('order_id') ){
            $query->where('order_id' , request('order_id') );
        }

        if ( request('reference_id') ){
            $query->where('reference_id' , request('reference_id') );
        }

        $this->rows = $query->paginate(40);
        return $this;
    }
    public function setColumns()
    {
        $this->addColumn([
            'name'=>'reference_id',
            'title'=>'شناسه',
        ]);
        $this->addColumn([
            'name'=>'created_at',
            'title'=>'تاریخ',
        ]);

        $this->addColumn([
            'name'=>'amount',
            'title'=>'مبلغ',
        ]);
        $this->addColumn([
            'name'=>'order_id',
            'title'=>'شماره سفارش',
        ]);

        $this->addColumn([
            'name'=>'user_name',
            'title'=>'نام کاربر',
        ]);

        $this->addColumn([
            'name'=>'type_text',
            'title'=>'نوع',
        ]);

        $this->addColumn([
            'name'=>'status_text_badage',
            'title'=>'وضعیت',
        ]);

        /*** actions ***/
        $this->addAction([
            'name'=>'edit',
            'title'=>'برسی',
            'url'=>array(
                'name' => 'admin.shop.payments.edit',
                'parameter' => ['id'],
                'method' => 'get',
            ),
            'class'=>'btn-warning',
        ]);

        /*** buttons ***/


        /*** filters ***/

        $this->addFilter([
            'name'=>'reference_id',
            'title'=>'شناسه',
            'type'=>'text',
        ]);

        $this->addFilter([
            'name'=>'order_id',
            'title'=>'شماره سفارش',
            'type'=>'text',
        ]);

        $this->addFilter([
            'name'=>'user_name',
            'title'=>'نام کاربر	',
            'type'=>'text',
        ]);

        return $this;
    }

    public function getRowUpdate($row)
    {
        $row->image = $row->image ? '<img src="'.url($row->image)  .'" style="width: 100px">' : '';
        $row->description = \mb_substr( $row->description , 0 , 20).' ...' ;
        $row->user_name =  $row->user->name ?? '-' ;

        return $row;
    }

    public function getActionUpdate($actions , $row)
    {
        if ($row->status == 1 || $row->type != 'bank_receipt' ){
            unset($actions[0]);
        }
        return $actions;
    }

    public function showGrid()
    {
        return $this->setGridData()->setColumns()->renderGridView();
    }

}
