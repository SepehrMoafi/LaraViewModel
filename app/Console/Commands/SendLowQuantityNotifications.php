<?php

namespace App\Console\Commands;

use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\SMS\SmsService;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Modules\Core\Entities\Setting;
use Modules\Shop\Entities\Product;

class SendLowQuantityNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-low-quantity-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        {
            $products = Product::query()->where('qty', '<=', 2)->count();
            $setting = Setting::whereCode('1025')->first();
            if ($products == 0) {
                $route = route('admin.shop.product.lowCount');
                $smsService = new SmsService();
                $smsService->setFrom(Config::get('sms.otp_from'));
                $smsService->setTo([json_decode($setting->main_setting)->site_mobileNumber]);
                $smsService->setText("تعداد بعضی از محصولات کمتر ار ۲ عدد میباشد برای مشاهده {$route}");
                $smsService->setIsFlash(true);
                $messagesService = new MessageService($smsService);
                $messagesService->send();
            }
        }
    }
}
