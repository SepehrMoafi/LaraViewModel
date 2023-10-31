<?php

namespace App\Console\Commands;

use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\SMS\SmsService;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Modules\Core\Entities\Setting;
use Modules\Shop\Entities\Product;
use Modules\Shop\ViewModels\Admin\Product\ProductTarazViewModel;

class UpdateProductsWithApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateProductsWithApi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'UpdateProductsWithApi';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $taraz_viewmodel = new ProductTarazViewModel();
        $taraz_viewmodel->updateTaraz();

        Log::alert('commad UPDATE TARAZ AT : ' . carbon()->now()->format('Y-m-d H:i:s'));
    }
}
