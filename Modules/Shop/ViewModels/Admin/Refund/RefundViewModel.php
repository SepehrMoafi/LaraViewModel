<?php

namespace Modules\Shop\ViewModels\Admin\Refund;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Core\Trait\GridTrait;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\Refund;
use Modules\User\Entities\Wallet;
use Modules\User\Entities\WalletTransaction;

class RefundViewModel extends BaseViewModel
{
    use GridTrait;

    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function setGridData($is_export = false)
    {
        $query = Refund::query();
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
            'title' => 'کاربر',
        ]);

        $this->addColumn([
            'name' => 'order_item_id',
            'title' => 'محصول',
        ]);

        $this->addColumn([
            'name' => 'status',
            'title' => 'وضعیت',
        ]);

        $this->addColumn([
            'name' => 'qty',
            'title' => 'تعداد',
        ]);

        $this->addColumn([
            'name' => 'amount',
            'title' => 'وجه قابل پرداخت',
        ]);

//        $this->addColumn([
//            'name' => 'reason',
//            'title' => 'دلیل',
//        ]);

//        $this->addColumn([
//            'name' => 'refund_method',
//            'title' => 'روش پرداخت',
//        ]);

        $this->addColumn([
            'name' => 'approved',
            'title' => 'وضعیت تایید',
        ]);

        $this->addColumn([
            'name' => 'refund_date',
            'title' => 'تاریخ پرداخت',
        ]);

//        $this->addColumn([
//            'name' => 'notes',
//            'title' => 'یادداشت',
//        ]);

        $this->addColumn([
            'name' => 'created_at',
            'title' => 'تاریخ ثبت',
        ]);

//        $this->addColumn([
//            'name' => 'updated_at',
//            'title' => 'تاریخ بروزرسانی',
//        ]);

        /*** actions ***/
        $this->addAction([
            'name' => 'edit',
            'title' => 'بررسی',
            'url' => array(
                'name' => 'admin.shop.refund.show',
                'parameter' => ['id'],
                'method' => 'get',
            ),
            'class' => 'btn-warning',
        ]);

        return $this;
    }

    public function show()
    {
        $refund = Refund::query()->findOrFail(request()->model_id);

        $data = [
            'refund' => $refund,
        ];
        return $this->renderView('shop::refund.show_form', $data);
    }

    public function approve()
    {
        $validation = request()->validate([
            'approved' => 'required|integer',
            'notes' => 'nullable|string',
            'model_id' => 'required|exists:refunds,id',
        ]);

        $refund = Refund::query()->findOrFail($validation['model_id']);

        if ($refund->status === 1){
            alert()->toast('وضعیت کالای مرجوعی تایید شده است و قابل ویرایش نیست .','error');
            return redirect()->back();
        }

        if ($validation['approved'] == 1) {
            if (!isset($refund->user->wallet)) {
                try {
                    DB::beginTransaction();
                    $wallet = new Wallet();
                    $wallet->user_id = $refund->user->id;
                    $wallet->amount = 0;
                    $wallet->save();

                } catch (\Exception $exception) {
                    DB::rollBack();
                    alert()->error('مشکلی پیش آمده در هنگام ساخت کیف پول برای کابر.');
                    Log::critical('wallet error is: ' . $exception->getMessage());
                    return redirect()->back();
                }
                DB::commit();
            }

            try {
                DB::beginTransaction();
                $walletTransaction = new WalletTransaction;
                $walletTransaction->user_id = $refund->user->id;
                $walletTransaction->payment_id = null;
                $walletTransaction->wallet_id = $refund->user->wallet->id;
                $walletTransaction->amount += $refund->amount;
                $walletTransaction->transaction_type = 'creditor';
                $walletTransaction->save();

            } catch (\Exception $exception) {
                DB::rollBack();
                alert()->error('مشکلی در هنگام ساخت تراکنش بوجود آمده است.');
                Log::critical('wallet transaction error is: ' . $exception->getMessage());
                return redirect()->back();
            }
            try {
                $wallet = $refund->user->wallet()->first();
                $wallet->amount += $refund->amount;
                $wallet->save();

            } catch (\Exception $exception) {
                DB::rollBack();
                alert()->error('مشکلی در هنگام اضافه کردن مبلغ به کیف پول پیش آمد آمده است.');
                Log::critical('wallet error is: ' . $exception->getMessage());
                return redirect()->back();
            }
        }


        try {
            $refund->status = $validation['approved'];
            $refund->refund_date = now();
            $refund->fill($validation);
            $refund->save();

        } catch (\Exception $exception) {
            DB::rollBack();
            alert()->error('مشکلی پیش آمده است');
            Log::critical('refund error is: ' . $exception->getMessage());
            return redirect()->back();
        }
        DB::commit();
        alert()->success('عملیات با موفقیت انجام شد');
        return to_route('admin.shop.refund.index');
    }

    public function getRowUpdate($row)
    {
        $row->user_id = $row->user->name ?? '-';
        $row->order_item_id = $row->orderItem->product()->catalog->title ?? '-';
        $row->approved = $row->approve_label;
        $row->status = $row->status_label;
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
