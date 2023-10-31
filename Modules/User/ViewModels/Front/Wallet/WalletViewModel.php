<?php

namespace Modules\User\ViewModels\Front\Wallet;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;
use Modules\Blog\Entities\PostCategoryRelation;
use Modules\Blog\Entities\postRelation;
use Modules\Blog\Entities\PostTag;
use Modules\Blog\Entities\PostTagRelation;
use Modules\Core\Entities\City;
use Modules\Core\Entities\State;
use Modules\Core\Http\Controllers\Admin\dropzone\DropZoneController;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\Order;
use Modules\Shop\Entities\Payment;
use Modules\Shop\Entities\ProductCatalog;
use Modules\Shop\ViewModels\Front\Payment\PaymentViewModel;
use Modules\User\Entities\UserFavorite;
use Modules\User\Entities\Wallet;
use Modules\User\Entities\WalletTransaction;
use Morilog\Jalali\Jalalian;
use function Psy\debug;

class WalletViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_master';
    }

    public function WalletPayForm()
    {
        $data = [
            'view_model' => $this,
        ];
        return $this->renderView('user::profile.wallet-pay-form', $data);
    }

    public function walletPaySubmit()
    {
        try {
            DB::beginTransaction();

            $order = new Order();
            $order->user_id = auth()->user()->id;
            $order->type = 2;
            $order->status = 0;
            $order->amount = request('amount');
            $order->payable_amount = request('amount');

            $order->save();

            if (request('bank_receipt') == 'on'){

                //receipt
                $payment = new Payment();
                $payment->user_id = $order->user_id;
                $payment->order_id = $order->id;
                $payment->amount = $order->payable_amount;
                $payment->type = 'bank_receipt';
                $payment->reference_id = 'abc'.rand(1000000 , 1000000000000);
                $payment->status = 0;

                if (request('bank_receipt_photo')){
                    $bank_receipt_photo = $this->uploadFile(request() , 'bank_receipt_photo' , 'payments');
                }else{
                    alert()->toast('لطفا تصویر فیش را آپلود کنید','warning' );
                    return redirect()->back()->withInput();
                }

                $params = new \stdClass();
                $params->bank_receipt_photo = $bank_receipt_photo;
                $payment->params = json_encode($params);
                $payment->save();
                $this->createTransaction($payment);
                DB::commit();
                alert()->success( ' ' , 'سفارش با موفقیت ثبت شد . در انتظار تایید فیش بانکی می باشد .');
                return redirect(route('front.user.profile.payments'));

            }else{

                $payment = new Payment();
                $payment->user_id = $order->user_id;
                $payment->order_id = $order->id;
                $payment->amount = $order->payable_amount;
                $payment->type = 'online';
                $payment->reference_id = 'ac'.rand(1000000 , 1000000000000);
                $payment->status = 0;

                $payment->save();
                $this->createTransaction($payment);
                DB::commit();
                return PaymentViewModel::sendToBank($payment);

            }
        }catch (\Exception $e){

            DB::rollBack();
            if ( env('APP_DEBUG') ){
                alert()->error('مشکلی پیش آمد',$e->getMessage() );
            }else{
                alert()->error('مشکلی پیش آمد','مشکلی در ثبت اطلاعات وجود دارد لطفا موارد را برسی کنید و مجدد تلاش کنید .');
            }
            return redirect()->back()->withInput();
        }

    }

    public function createTransaction($payment)
    {
        $walletTransaction = new WalletTransaction();
        $walletTransaction->user_id = auth()->user()->id;
        $walletTransaction->payment_id = $payment->id;
        $walletTransaction->wallet_id = WalletViewModel::getWallet()->id;
        $walletTransaction->amount = request('amount');
        $walletTransaction->transaction_type = 'debtor';

        $walletTransaction->save();
        return $walletTransaction;
    }

    public static function getWallet()
    {
        if ( auth()->user() ){

            $wallet = Wallet::where('user_id' , auth()->user()->id)->first();
            if (! $wallet){
                $wallet = new Wallet();
                $wallet->user_id = auth()->user()->id;
                $wallet->amount = 0;
                $wallet->save();
            }
            return $wallet ;

        }else{
            return null;
        }


    }
}
