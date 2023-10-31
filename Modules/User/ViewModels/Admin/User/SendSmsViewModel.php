<?php

namespace Modules\User\ViewModels\Admin\User;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Modules\Core\Trait\GridTrait;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\User\Entities\NewsletterSubscription;
use Modules\User\Notifications\NewsletterSubscriptionNotification;

class SendSmsViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function index()
    {
        $users = User::query()->select(['name', 'id'])->get();
        $data = [
            'users' => $users,
        ];

        return $this->renderView('user::user.sendSmsForm', $data);
    }

    public function sendSms()
    {

        try {
            $validatedData = request()->validate([
                'message' => 'required|string|max:255',
                'users.*' => 'required|numeric',
            ]);

            $users = User::query()->find([$validatedData['users']]);
            foreach ($users as $user) {
                $user->notifyNow(new NewsletterSubscriptionNotification($validatedData['message']));
            }
        }catch (\Exception $exception){
            Log::critical('sendSms error is : '.$exception->getMessage());
            alert()->toast( 'مشکلی در ارسال پیام به وجود آمد' , 'error' );
            return redirect()->back();
        }
        alert()->toast('یبام شما با موفقیت انجام شد.' , 'success');
        return redirect()->back();
    }
}
