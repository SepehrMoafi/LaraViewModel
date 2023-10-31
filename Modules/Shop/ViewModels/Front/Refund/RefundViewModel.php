<?php

namespace Modules\Shop\ViewModels\Front\Refund;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\OrderItem;
use Modules\Shop\Entities\Refund;

class RefundViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_master';
    }

    public function refund(Request $request): RedirectResponse
    {
        $itemId = $request->item_id;
        $orderItem = OrderItem::findOrFail($itemId);

        $validator = $this->validateRefundRequest($request,$orderItem);

        if ($orderItem->order->payable_amount !== 0){
            alert()->toast('برای ثبت درخواست مرجوعی باید هزینه سفارش را کامل پرداخت کنید', 'error');
            return redirect()->back();
        }

        if ($orderItem->order->user_id !== \Auth::id()){
            Log::channel('violation')->critical('User '. \Auth::id() .' tried to change form value');
            alert()->toast('گزارش تخلف شما در سیستم ثبت شد', 'error');
            return redirect()->back();
        }

        if ($validator->fails()) {
            alert()->toast('لطفا فیلد ها را به درستی وارد کنید', 'error');
            return redirect()->back();
        }

        if (isset($orderItem->refund)){
            alert()->toast('برای این محصول قبلا درخواست مرجوعی داده است', 'error');
            return redirect()->back();
        }

        $validator = $validator->validated();

        try {
            DB::beginTransaction();
            $refund = Refund::query()->create(
                [
                    'user_id' => \Auth::id(),
                    'order_item_id' => $orderItem->id,
                    'amount' => $orderItem->total_amount/$orderItem->qty,
                    'qty' => $validator['qty'] ?? 1,
                    'reason' => $validator['reason'] ?? null,
                    'refund_method' => $validator['refund_method'] ?? null,
                ]
            );

        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::critical('refund error is : ' . $exception->getMessage());
            alert()->toast('مشکلی در ثبت کالای مرجوعی پیش آمد.', 'error');
            return redirect()->back();
        }
        DB::commit();
        alert()->toast('درخواست شما با موفقیت ثبت شد', 'success');
        return redirect()->back();
    }

    /**
     * @param OrderItem|array|\LaravelIdea\Helper\Modules\Shop\Entities\_IH_OrderItem_C $orderItem
     * @return \Illuminate\Validation\Validator
     */
    public function validateRefundRequest($request,OrderItem|array|\LaravelIdea\Helper\Modules\Shop\Entities\_IH_OrderItem_C $orderItem): \Illuminate\Validation\Validator
    {
        return Validator::make($request->all(), [
            'qty' => 'nullable|integer|min:1|max:' . $orderItem->qty,
            'reason' => 'nullable|string',
            'refund_method' => 'nullable|string',
        ]);
    }

}
