<?php

namespace Modules\User\ViewModels\Front\NewsletterSubscription;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\User\Entities\NewsletterSubscription;
use Modules\User\Notifications\NewsletterSubscriptionNotification;
use Illuminate\Support\Facades\Notification;

class NewsletterSubscriptionStoreViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_master';
    }

    public function store(): RedirectResponse
    {
        $validatedData = request()->validate(NewsletterSubscription::validationRules());

        try {

            DB::beginTransaction();

            $subscription = new NewsletterSubscription();

            $subscription->email = $validatedData['email'] ?? null;
            $subscription->mobile_number = $validatedData['mobile_number'] ?? null;
            $subscription->save();
            if ($subscription->mobile_number){
                $subscription->notifyNow(new NewsletterSubscriptionNotification([$subscription->mobile_number], 'با تشکر از شما برای عضویت در خبرنامه ما!'));
            }

        } catch (\Exception $e) {
            DB::rollBack();

            Log::critical('NewsletterSubscription error is : ' . $e->getMessage());

            alert()->toast( 'مشکلی در ذخیره سازی به وجود آمد' , 'error' );
            return redirect()->back();
        }

        DB::commit();

        alert()->toast( 'اطلاعات شما با موفقیت ذخیره شد.' , 'success' );
        return redirect()->back();
    }
}

