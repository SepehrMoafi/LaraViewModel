<?php

namespace Modules\Shop\ViewModels\Admin\Order;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;
use Modules\Core\Entities\Slider;
use Modules\Core\Trait\GridTrait;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\Brand;
use Modules\Shop\Entities\Order;
use Modules\Shop\Entities\Payment;
use Modules\Shop\Entities\Product;
use Modules\Shop\Entities\ProductCatalogCategory;
use Modules\User\Entities\Wallet;
use Modules\User\Entities\WalletTransaction;
use function Modules\Blog\ViewModels\Admin\Post\mb_substr;

class OrderViewModel extends BaseViewModel
{
    use GridTrait;
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function setGridData($is_export = false)
    {
        $query = Order::query();

        if ( request('user_name') ){
            $query->whereHas('user' , function ($q){
                $q->where('name' , 'like' , '%' .request('user_name').'%');
            });
        }

        if ( request('good_id') ){
            $query->whereHas('order_items' , function ($q){
                $q->where('item_type' , Product::class )->whereHasMorph('item' , [Product::class] , function ($qa){
                    $qa->where('good_id' , request('good_id') );
                });
            });
        }

        if ( request('category_id') ){
            $query->whereHas('order_items' , function ($q){
                $q->whereHasMorph('item' , [Product::class] , function ($qa){
                    $qa->whereHas('catalog' , function ($qn){
                        $qn->whereHas( 'categories' , function ($qm) {
                            foreach (request('category_id') as $key => $item) {
                                if ($key == 0){
                                    $qm->where('category_id' , $item);
                                }else{
                                    $qm->orWhere('category_id' , $item);
                                }
                            }
                        });
                    });
                });
            });
        }

        if ( request('id') ){
            $query->where('id' , request('id') );
        }

        if (request('start_date') && request('end_date')){

            $s_date =  \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y-m-d', request('start_date') )->format('Y-m-d');
            $e_date =  \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y-m-d', request('end_date') )->format('Y-m-d');

            $query->whereBetween('created_at' , [$s_date , $e_date] );
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
            'name'=>'id',
            'title'=>'شماره سفارش',
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
            'name'=>'payable_amount',
            'title'=>'قابل پرداخت',
        ]);

        $this->addColumn([
            'name'=>'user_name',
            'title'=>'نام کاربر',
        ]);


        $this->addColumn([
            'name'=>'status_text_badage',
            'title'=>'وضعیت',
        ]);

        /*** actions ***/
        $this->addAction([
            'name'=>'edit',
            'title'=>'تغییر وضعیت',
            'url'=>array(
                'name' => 'admin.shop.orders.edit',
                'parameter' => ['id'],
                'method' => 'get',
            ),
            'class'=>'btn-warning',
        ]);

        $this->addAction([
            'name'=>'edit',
            'title'=>'فاکتور',
            'url'=>array(
                'name' => 'admin.shop.orders.factor',
                'parameter' => ['id'],
                'method' => 'get',
            ),
            'class'=>'btn-primary',
        ]);

        $this->addAction([
            'name'=>'send_to_api',
            'title'=>'تلاش مجدد تراز',
            'url'=>array(
                'name' => 'admin.shop.orders.send_api',
                'parameter' => ['id'],
                'method' => 'get',
            ),
            'class'=>'btn-danger',
        ]);

        /*** buttons ***/


        /*** filters ***/

        $this->addFilter([
            'name'=>'id',
            'title'=>'شماره سفارش',
            'type'=>'text',
        ]);

        $this->addFilter([
            'name'=>'user_name',
            'title'=>'نام کاربر	',
            'type'=>'text',
        ]);

        $this->addFilter([
            'name'=>'start_date',
            'title'=>'تاریخ شروع',
            'type'=>'date',
        ]);

        $this->addFilter([
            'name'=>'end_date',
            'title'=>'تاریخ پایان',
            'type'=>'date',
        ]);

        $this->addFilter([
            'name'=>'good_id',
            'title'=>'کد کالا',
            'type'=>'text',
        ]);

        $cats = ProductCatalogCategory::query()->pluck('title' , 'id')->toArray();
        $this->addFilter([
            'name'=>'category_id',
            'title'=>'دسته بندی',
            'type'=>'select_tag',
            'options' => $cats
        ]);

        $this->can_export = true;
        $this->can_import = true;
        return $this;
    }

    public function getRowUpdate($row)
    {
        $row->user_name =  $row->user->name ?? '-' ;
        $row->created_at =  jdate($row->created_at)->format('Y-m-d H:i') ;

        return $row;
    }

    public function getActionUpdate($actions , $row)
    {
        if ($row->api_status == 2 || $row->status == 0){
            unset($actions[2]);
        }
        return $actions;
    }

    public function showGrid()
    {
        return $this->setGridData()->setColumns()->renderGridView();
    }

    public function getRowExportUpdate($row)
    {
        $res = new Collection(
            [
                'id' => $row->id ,
                'created_at' =>  jdate($row->created_at)->format('Y-m-d H:i'),

                'amount' => $row->amount ,
                'payable_amount' => $row->payable_amount ,
                'user_name' =>  $row->user->name ?? '-' ,
                'status' => $row->status ?? '0' ,
            ]
        );
        return $res;
    }

    public function getRowImportUpdate($row)
    {

        $order = Order::find($row[0]);

        if ( $order && $order->status != $row[5]){
            $order->status = $row[5] ?? 0;
            $order->save();
            //todo send notif
        }
    }

}
