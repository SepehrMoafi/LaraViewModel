<?php

namespace Modules\Shop\ViewModels\Front\LuckyWheel;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\Copan;
use Modules\Shop\Entities\Gift;
use Modules\Shop\Entities\GiftItem;
use Modules\Shop\Entities\OrderItem;
use Modules\Shop\Entities\Product;
use Modules\Shop\Entities\ProductCatalog;
use Modules\Shop\Entities\UserGift;

class LuckyWheelViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_master';
    }

    public function show()
    {
        $gift = Gift::query()->findOrFail(request()->model_id);
        $order_item = request()->input('order_item');
        $userOrderItem = OrderItem::query()->findOrFail($order_item);
        $userGiftCount = UserGift::query()->where('user_id', \Auth::id())->where('gift_id', $gift->id)->count();

        if ($userGiftCount >= $gift->maximum_use) {
            alert()->toast('شما قبلا در این گردانه شرکت کرده اید.', 'error');
            return redirect()->back();
        }
        if ($userOrderItem->order->status !== 1) {
            alert()->toast('شما مبلغ سفارش را کامل پرداخت نکردبد', 'error');
            return redirect()->back();
        }

        if ($userOrderItem->order->user_id !== \Auth::id()) {
            alert()->toast('این سفارش برای شما نیست', 'error');
            return redirect()->back();
        }

        if ($gift->product_catalog_id !== $userOrderItem->item_id) {
            alert()->toast('این سفارش گردانه شانس ندارد', 'error');
            return redirect()->back();
        }

        if ($userOrderItem->item_type !== Product::class) {
            alert()->toast('محصول مورد نظر مطابق کالا های ما نیست', 'error');
            return redirect()->back();
        }

        $products = GiftItem::query()
            ->where('gift_id', $gift->id)
            ->where(function ($query) {
                $query->where('itemable_type', ProductCatalog::class)
                    ->orWhere('itemable_type', Copan::class);
            })
            ->get();

        $data = [
            "gift" => $gift,
            "products" => $products,
        ];
        return $this->renderView('shop::luckyWheel.index', $data);
    }

    public function win()
    {
        $giftItem = GiftItem::findOrFail(request()->model_id);

        $gift = Gift::query()->findOrFail($giftItem->gift_id);

        $order_item = request()->input('order_item');
        $userOrderItem = OrderItem::query()->findOrFail($order_item);
        $userGiftCount = UserGift::query()->where('user_id', \Auth::id())->where('gift_id', $gift->id)->count();

        if ($userGiftCount >= $gift->maximum_use) {
            alert()->toast('شما قبلا در این گردانه شرکت کرده اید.', 'error');
            return to_route('front.user.profile.orders');
        }
        if ($userOrderItem->order->status !== 1) {
            alert()->toast('شما مبلغ سفارش را کامل پرداخت نکردبد', 'error');
            return to_route('front.user.profile.orders');
        }

        if ($userOrderItem->order->user_id !== \Auth::id()) {
            alert()->toast('این سفارش برای شما نیست', 'error');
            return to_route('front.user.profile.orders');
        }

        if ($gift->product_catalog_id !== $userOrderItem->item_id) {
            alert()->toast('این سفارش گردانه شانس ندارد', 'error');
            return to_route('front.user.profile.orders');
        }

        if ($userOrderItem->item_type !== Product::class) {
            alert()->toast('محصول مورد نظر مطابق کالا های ما نیست', 'error');
            return to_route('front.user.profile.orders');
        }

        $userGiftCount = UserGift::query()->where('user_id', \Auth::id())->where('gift_id', $giftItem->gift_id)->count();
        $maximumUse = $giftItem->gift->maximum_use;
        if ($userGiftCount >= $maximumUse) {
            alert()->toast('تعداد دفعات استفاده از گردونه به اتمام رسیده', 'warning');
            return to_route('front.user.profile.orders');
        }

        $className = $giftItem->itemable_type;
        $model = app($className)->findOrFail($giftItem->itemable_id);

        try {
            DB::beginTransaction();
            $userGift = new UserGift;
            $userGift->user_id = \Auth::id();
            $userGift->gift_id = $giftItem->gift_id;
            $userGift->gift_item_id = $giftItem->id;
            $userGift->save();
        } catch (\Exception $exception) {
            DB::rollBack();
            alert()->toast('مشکلی پیش آمده است', 'error');
            Log::critical('User_Gift error is: ' . $exception->getMessage());
        return to_route('front.user.profile.orders');
        }
        DB::commit();

        if ($model instanceof Copan) {
            alert()->toast("تبریک شما برنده ی کد تخفیف {$model->amount} درصدی شدید", 'success');
        } elseif ($model instanceof ProductCatalog) {
            alert()->toast("تبریک شما برنده ی {$model->title} شدید", 'success');
        }
        return to_route('front.user.profile.orders');
    }
}

