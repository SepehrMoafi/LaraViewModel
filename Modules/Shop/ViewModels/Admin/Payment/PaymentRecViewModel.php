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
use Modules\User\Notifications\NewsletterSubscriptionNotification;
use function Modules\Blog\ViewModels\Admin\Post\mb_substr;

class PaymentRecViewModel extends BaseViewModel
{
    use GridTrait;
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function setGridData()
    {
        $query = Payment::query();
        $query->where('type' , 'bank_receipt');
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

    public function store($request)
    {
        $validated = $request->validate([
            'amount' => 'required',
            'status' => 'required',
        ]);
        return $this->saveService($validated , $request);

    }

    public function edit($request)
    {
        $this->modelData = Payment::find( $request->model_id );
        $data = [
            'view_model' => $this,
        ];
        return $this->renderView('shop::payment.form' ,$data);
    }

    public function update($request)
    {
        return $this->store($request);
    }

    public function saveService( $validData ,  $request)
    {
        try {
            DB::beginTransaction();
            $model = Payment::find( $request->model_id ) ?? new Payment();

            $params = $model->params ? json_decode($model->params) : new \stdClass();

            if ($request['params']){

                foreach ($request['params'] as $key => $data){
                    $params->$key = $data;
                }
                $model->params = json_encode($params);
                unset($validData['params']);

            }
            $model->status = request('status');

            if ($model->status === 1){
                $model->user->notifyNow(new NewsletterSubscriptionNotification("پرداخت شما با موفقیت انجام شد"));
            }else{
                $model->user->notifyNow(new NewsletterSubscriptionNotification("پرداخت شما انجام نشد"));
            }

            $model->amount = request('amount');
            $model->save();

            $for_wallet = WalletTransaction::where('payment_id' , $model->id)->first();
            if ($for_wallet){
                $wallet = Wallet::find($for_wallet->wallet_id);
                $wallet->amount += $model->amount ;
                $wallet->user->notifyNow(new NewsletterSubscriptionNotification("مقدار {$model->amount} به کیف پول شما اضافه شد"));
                $wallet->save();
            }
            DB::commit();

            alert()->success('با موفقیت انجام شد');
            return redirect(route('admin.shop.payments.index-rec'));

        } catch (\Exception $e){

            DB::rollBack();
            if ( env('APP_DEBUG') ){
                alert()->error('مشکلی پیش آمد',$e->getMessage() );
            }else{
                alert()->error('مشکلی پیش آمد','مشکلی در ثبت اطلاعات وجود دارد لطفا موارد را برسی کنید و مجدد تلاش کنید .');
            }
            return redirect()->back()->withInput();

        }

    }

}
