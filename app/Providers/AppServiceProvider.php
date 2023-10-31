<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use Modules\User\Notifications\SmsChannel;
use Nwidart\Modules\Facades\Module;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Notification::extend('sms', function ($app) {
            return $app->make(SmsChannel::class);
        });
        $modules = Module::getByStatus(1);
        $menus = [];
        foreach ($modules as $key => $module) {
            $base_config_url = $module->getPath() . '/Config/backend.php';
            $menus[$key] = File::getRequire($base_config_url);
        }
        view()->share('back_menus', $menus );
    }
}
