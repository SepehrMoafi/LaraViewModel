<?php

namespace Modules\Shop\ViewModels\Front\Payment;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;
use Modules\Blog\Entities\PostCategoryRelation;
use Modules\Blog\Entities\postRelation;
use Modules\Blog\Entities\PostTag;
use Modules\Blog\Entities\PostTagRelation;
use Modules\Core\Entities\Comment;
use Modules\Core\Http\Controllers\Admin\dropzone\DropZoneController;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\Attribute;
use Modules\Shop\Entities\Brand;
use Modules\Shop\Entities\Order;
use Modules\Shop\Entities\Payment;
use Modules\Shop\Entities\Product;
use Modules\Shop\Entities\ProductCatalog;
use Modules\Shop\Entities\ProductCatalogCategory;
use Modules\Shop\Entities\ProductCatalogCategoryRel;
use Modules\Shop\Entities\ProductCatalogRel;
use Modules\Shop\Entities\ProductCatalogRelAccessory;
use Modules\Shop\Service\Payment\Mellat\BankMellatPayment;
use Modules\User\Entities\Wallet;
use Modules\User\Entities\WalletTransaction;
use Modules\User\ViewModels\Front\Wallet\WalletViewModel;
use Morilog\Jalali\Jalalian;
use function Psy\debug;

class PaymentViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_master';
    }

    public static function sendToBank($payment)
    {
        $mellat_get_way = new BankMellatPayment();
        $mobile = auth()->user()->mobile;

        $res = $mellat_get_way->paymentRequest($payment->amount.'0' , $payment->id, '', auth()->user()->id , route('front.shop.payment.order-payment-callback'));

        $result = @$res['result'];
        $res_code = @$res['res_code'];
        $ref_id = @$res['ref_id'];
        if ($ref_id && $result) {

            $payment->reference_id = $ref_id;
            $payment->save();

            //send to bank and exit
            return view('shop::theme_master.payment.send_to_bank' , ['ref_id' => $ref_id , 'mobile' => $mobile ] );
        }
        alert()->warning(' ', ' ارسال به بانک با موفقیت انجام نشد روی دکمه  پرداخت کلیک کنید ');
        return redirect(route('front.user.profile.orders'));

    }

    public function ordersRepay()
    {
        $order = Order::query()
            ->where('user_id' , auth()->user()->id )
            ->where('id' , request('model_id') )
            ->first();

        $payment = new Payment();
        $payment->user_id = $order->user_id;
        $payment->order_id = $order->id;
        $payment->amount = $order->payable_amount;
        $payment->type = 'online';
        $payment->reference_id = 'ac' . rand(1000000, 1000000000000);
        $payment->status = 0;

        $payment->save();

        DB::commit();

        return $this->sendToBank($payment);

    }

    public function callBack()
    {
        $mellat_get_way = new BankMellatPayment();
        $orderId = request('orderId') ?? request('SaleOrderId');
        $ref_id = request('RefId');
        $SaleOrderId = request('SaleOrderId');
        $SaleReferenceId = request('SaleReferenceId');

        $return_bank_message['request_input'] = request()->input();
        $payment = Payment::where('id', $orderId)->first();

        if ( !$payment ){
            alert()->error(' ', 'پرداخت یافت نشد');
            return redirect(route('front.user.profile.orders'));
        }

        if ($payment->status == 1) {
            alert()->success(' ', 'پرداخت قبلا با موفقیت ثبت شده است ');
            return redirect(route('front.user.profile.orders'));
        }

        //3-verify-transaction
        $verify_result = $mellat_get_way->verifyPayment($SaleOrderId, $SaleOrderId, $SaleReferenceId);
        $return_bank_message['verify_result'] = $verify_result;
        //5-settle-transaction
        $settle_payment_result = $mellat_get_way->settlePayment($SaleOrderId, $SaleOrderId, $SaleReferenceId);
        $return_bank_message['settle_payment_result'] = $settle_payment_result;

        if ((isset($settle_payment_result->return)) && ((@$settle_payment_result->return == 45) || ($settle_payment_result->return == 0))) {

            $payment->status = 1 ;
            $payment->paid_date =  Carbon::now();
            $payment->save();
            $order = Order::find($payment->order_id);

            if ($order){
                $order->status = 1 ;
                $order->payable_amount = $order->payable_amount - $payment->amount;
                $order->save();
            }

            $for_wallet = WalletTransaction::where('payment_id' , $payment->id)->first();
            if ($for_wallet){
                $wallet = Wallet::find($for_wallet->wallet_id);
                $wallet->amount += $payment->amount ;
                $wallet->save();
            }

            alert()->success(' ', 'پرداخت با موفقیت ثبت شد');
            return redirect(route('front.user.profile.orders'));

        } else {

            alert()->error(' ', 'پرداخت با موفقیت انجام نشد');
            return redirect(route('front.user.profile.orders'));

        }

    }
}
