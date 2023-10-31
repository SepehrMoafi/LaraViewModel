<?php

namespace Modules\Shop\ViewModels\Front\Cart;

use App\Models\User;
use Carbon\Carbon;
use Darryldecode\Cart\Cart;
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
use Modules\Shop\Entities\Copan;
use Modules\Shop\Entities\DeliveryType;
use Modules\Shop\Entities\Order;
use Modules\Shop\Entities\OrderInfo;
use Modules\Shop\Entities\OrderItem;
use Modules\Shop\Entities\Payment;
use Modules\Shop\Entities\Product;
use Modules\Shop\Entities\ProductCatalog;
use Modules\Shop\Entities\ProductCatalogCategory;
use Modules\Shop\Entities\ProductCatalogCategoryRel;
use Modules\Shop\Entities\ProductCatalogRel;
use Modules\Shop\Entities\ProductCatalogRelAccessory;
use Modules\Shop\Service\Payment\Mellat\BankMellatPayment;
use Modules\Shop\ViewModels\Front\Payment\PaymentViewModel;
use Modules\User\Entities\Address;
use Modules\User\Entities\WalletTransaction;
use Morilog\Jalali\Jalalian;
use function Psy\debug;

class CheckoutViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_master';
    }

    public function checkout()
    {
        $products = ProductCatalog::query()->paginate(30);
        $cart = $this->getCart();

        $states = State::all();

        $stateCityData = [];
        foreach ($states as $state) {
            $cities = City::query()->where('state_id', $state->id)->get()->toArray();
            $stateCityData[] = [
                'state_id' => $state->id,
                'state_name' => $state->name,
                'cities' => $cities,
            ];
        }

        $delivery_type = DeliveryType::query()->where('status', 1)->get();

        $data = [
            'view_model' => $this,
            'products' => $products,
            'stateCityData' => $stateCityData,
            'cart' => $cart,
            'delivery_type' => $delivery_type,
        ];

        return $this->renderView('shop::cart.checkout', $data);
    }

    public function checkCopan()
    {
        $cart = $this->getCart();
        $discountCode = request()->discountBtn;

        $copan = Copan::where('code', $discountCode)->first();

        if (!$copan) {
            alert()->toast('کد تخفیف وجود ندارد', 'error');
            return redirect()->back();
        }

        if ($copan->first_buy && \Auth::user()->payments->count() !== 0) {
            alert()->toast('کد تخفیف برای خرید اول است', 'warning');
            return redirect()->back();
        }
//TODO discount allowed_number_of_uses - order Larry
        if ($copan->allowed_number_of_uses === 0) {
            alert()->toast('کد تخفیف به اتمام رسیده است', 'warning');
            return redirect()->back();
        }
//        $sum = $cart->getContent()->sum(fn ($item) => $item->price * $item->quantity);
//        $discountAmount = $sum * ($copan->amount / 100);
//        $priceWithDiscountCode = $sum - $discountAmount;

        session(['copanId' => $copan->id]);
        alert()->toast('کد تخفیف با موفقیت اعمال شد', 'success');

        return redirect()->route('front.shop.cart.checkout');

    }

    public function getDiscountAmount()
    {
        $discountAmount = 0;
        foreach ($this->getCart()->getContent() as $item) {
            $originalPrice = $item->price;
            $discountedPrice = ($originalPrice * $item->attributes->product->discount / 100);
            // Update the price of the item
            $discountAmount += $discountedPrice * $item->quantity;
        }
        $lastPrice = $this->getSumCartItemsWithDiscount();

        if (session()->has('copanId')) {
            $copan=Copan::query()->find(session()->get('copanId'));
            $discountAmountCopan = $lastPrice * ($copan->amount / 100);
            $discountAmount += $discountAmountCopan;
        }

        return $discountAmount;
    }

    public function getCart()
    {

        if (auth()->user() && false) {
            $cart_key = session()->has('cart_key') ? session('cart_key') : auth()->user()->id;
        } else {
            $cart_key = session()->has('cart_key') ? session('cart_key') : rand(1000000, 9099999999999);
            session(['cart_key' => $cart_key]);
        }
        return CartViewModel::updateCartItems(\Cart::session($cart_key));
    }


    public function saveCheckout()
    {
        if (!request('address_id')) {
            alert()->toast('لطفا آدرسی را انتخاب کنید', 'warning');
            return redirect()->back()->withInput();
        }

        if (!request('send_type')) {
            alert()->toast('لطفا نوع ارسال را انتخاب کنید', 'warning');
            return redirect()->back()->withInput();
        }else{

            $delivery = DeliveryType::find( request('send_type') );
            $selectedCity = $delivery->cities_id ? json_decode($delivery->cities_id , true) : [];
            if (count($selectedCity) > 0){
                $address = Address::find( request('address_id') );
                $valid = in_array($address->city , $selectedCity );
                if (!$valid){
                    alert()->toast('نوع ارسال برای آدرس شما فعال نیست', 'warning');
                    return redirect()->back()->withInput();
                }
            }

        }

        if (!request('delivery_date')) {
            alert()->toast('لطفا تاریخ ارسال را انتخاب کنید', 'warning');
            return redirect()->back()->withInput();
        }

        try {
            DB::beginTransaction();
            $order = $this->createOrder();

            session()->remove('cart_key');
            if (request('pay_by_wallet')){
                $wallet = \Modules\User\ViewModels\Front\Wallet\WalletViewModel::getWallet() ;
                if ($wallet->amount > 0){
                    $this-> createWalletPaymentAndUpdateOrder($order , $wallet);
                    DB::commit();
                }

            }
            if ($order->payable_amount == 0){
                DB::commit();
                alert()->success(' ', 'سفارش با موفقیت ثبت شد . ');
                return redirect(route('front.user.profile.orders'));
            }

            if (request('bank_receipt') == 'on') {
                return $this->createBankReceiptPayment($order);
            } else {
                return $this->createPayment($order);
            }
            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();
            if (env('APP_DEBUG')) {
                alert()->error('مشکلی پیش آمد', $e->getMessage());
            } else {
                alert()->error('مشکلی پیش آمد', 'مشکلی در ثبت اطلاعات وجود دارد لطفا موارد را برسی کنید و مجدد تلاش کنید .');
            }
            return redirect()->back()->withInput();
        }

    }

    private function createWalletPaymentAndUpdateOrder($order , $wallet){
        $remaining_wallet_amount = $wallet->amount - $order->payable_amount;
        if ($remaining_wallet_amount >= 0){
            // can pay compliantly

            $wallet_payment = $this->createWalletPayment($order , $order->payable_amount);
            $wallet_transaction = $this->createWalletTransaction($order , $wallet_payment , $wallet);

            $order->status = 1 ;
            $order->payable_amount = $order->payable_amount - $wallet_payment->amount;
            $order->save();

            $wallet->amount = $remaining_wallet_amount;
            $wallet->save();
        }else{
            // Pay part of the cost

            $remaining_order_amount = $order->payable_amount - $wallet->amount;

            $wallet_payment = $this->createWalletPayment($order , $wallet->amount);
            $wallet_transaction = $this->createWalletTransaction($order , $wallet_payment , $wallet);

            $order->payable_amount = $remaining_order_amount;
            $order->save();

            $wallet->amount = 0;
            $wallet->save();

        }
    }

    private function createWalletPayment($order , $amount){
        $wallet_payment = new Payment();
        $wallet_payment->user_id = $order->user_id;
        $wallet_payment->order_id = $order->id;
        $wallet_payment->amount = $amount;
        $wallet_payment->type = 'wallet';
        $wallet_payment->reference_id = 'aw' . rand(1000000, 1000000000000);
        $wallet_payment->status = 1;
        $wallet_payment->paid_date =  Carbon::now();
        $wallet_payment->save();
        return $wallet_payment ;
    }

    private function createWalletTransaction($order , $wallet_payment , $wallet){
        $wallet_transaction = new WalletTransaction();
        $wallet_transaction->user_id = $order->user_id;
        $wallet_transaction->payment_id = $wallet_payment->id;
        $wallet_transaction->wallet_id = $wallet->id;
        $wallet_transaction->amount = $wallet_payment->amount;
        $wallet_transaction->transaction_type = 'creditor';
        $wallet_transaction->save();
        return $wallet_transaction ;
    }

    private function createOrder()
    {

        $cart = $this->getCart();
        $order_items = [];
        $total_price = 0;
        foreach ($cart->getContent() as $item) {
            $pt = Product::find($item->id);
            $total_product_price = ($pt->discount ?  ($pt->price)*(1-($pt->discount/100)) : $pt->price) * $item->quantity;
            $total_price += $total_product_price;
            $order_items[] = [
                'item_type' => Product::class,
                'item_id' => $item->id,
                'qty' => $item->quantity,
                'amount' => $item->price,
                'discount_amount' => $item->discount ?  ( $item->price * ( $item->discount / 100 ) ) : 0 ,
                'total_amount' => $total_product_price,
            ];
        }
        if ( request('send_type') ){

            $delivery = DeliveryType::find( request('send_type') );
            $total_price += $delivery->price;
            $order_items[] = [
                'item_type' => DeliveryType::class,
                'item_id' => $delivery->id ,
                'qty' => 1,
                'amount' => $delivery->price,
                'discount_amount' => 0 ,
                'total_amount' => $delivery->price,
            ];

        }

        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->type = 1;
        $order->status = 0;

        $total_price = $this->handelCopan($total_price);

        $order->amount = $total_price;
        $order->payable_amount = $total_price;

        $params = new \stdClass();
        $params->show_factor = request('show_factor') == 'on' ? 1 : 0;

        $order->params = json_encode($params);
        $order->save();

        foreach ($order_items as $order_item) {
            $order_item_obj = new OrderItem();
            $order_item_obj->order_id = $order->id;
            $order_item_obj->item_type = $order_item['item_type'];
            $order_item_obj->item_id = $order_item['item_id'];
            $order_item_obj->qty = $order_item['qty'];
            $order_item_obj->amount = $order_item['amount'];
            $order_item_obj->discount_amount = $order_item['discount_amount'];
            $order_item_obj->total_amount = $order_item['total_amount'];
            $order_item_obj->save();
        }

        $order_info = new OrderInfo();
        $order_info->user_id = $order->user_id;
        $order_info->order_id = $order->id;
        $order_info->send_type = request('send_type');
        $order_info->send_date = request('delivery_date');
        $order_info->address_id = request('address_id');

        $order_info->save();

        return $order;

    }


    private function createPayment($order)
    {
        $payment = new Payment();
        $payment->user_id = $order->user_id;
        $payment->order_id = $order->id;
        $payment->amount = $order->payable_amount;
        $payment->type = 'online';
        $payment->reference_id = 'ac' . rand(1000000, 1000000000000);
        $payment->status = 0;

        $payment->save();

        DB::commit();

        return PaymentViewModel::sendToBank($payment);
    }




    private function createBankReceiptPayment($order)
    {

        //receipt
        $payment = new Payment();
        $payment->user_id = $order->user_id;
        $payment->order_id = $order->id;
        $payment->amount = 0;
        $payment->type = 'bank_receipt';
        $payment->reference_id = 'abc' . rand(1000000, 1000000000000);
        $payment->status = 0;

        if (request('bank_receipt_photo')) {
            $bank_receipt_photo = $this->uploadFile(request(), 'bank_receipt_photo', 'payments');
        } else {
            alert()->toast('لطفا تصویر فیش را آپلود کنید', 'warning');
            return redirect()->back()->withInput();
        }

        $params = new \stdClass();
        $params->bank_receipt_photo = $bank_receipt_photo;
        $payment->params = json_encode($params);
        $payment->save();
        DB::commit();
        alert()->success(' ', 'سفارش با موفقیت ثبت شد . در انتظار تایید فیش بانکی می باشد .');
        return redirect(route('front.user.profile.orders'));
    }

    /**
     * @param $cart
     * @return void
     */
    public function getPayableAmount()
    {
        $lastPrice = $this->getSumCartItemsWithDiscount();
        return $this->handelCopan($lastPrice);
    }

    public function handelCopan($lastPrice)
    {
        if (session()->has('copanId')) {
            $copan=Copan::query()->find(session()->get('copanId'));
            $discountAmount = $lastPrice * ($copan->amount / 100);
            $priceWithDiscountCode = $lastPrice - $discountAmount;
            $lastPrice = $priceWithDiscountCode;

        }
        return $lastPrice ;

    }

    public function getSumCartItemsWithDiscount()
    {
        $lastPrice = 0;
        foreach ($this->getCart()->getContent() as $item) {
            $originalPrice = $item->price;
            $discountedPrice = $originalPrice - ($originalPrice * $item->attributes->product->discount / 100);
            // Update the price of the item
            $lastPrice += $discountedPrice * $item->quantity;
        }
        return $lastPrice ;
    }
}
