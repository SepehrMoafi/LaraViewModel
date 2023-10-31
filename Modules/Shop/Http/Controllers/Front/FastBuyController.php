<?php

namespace Modules\Shop\Http\Controllers\Front;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class FastBuyController
{
    public function index(Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setViewModel('front.fastBuy.FastBuy')
            ->setAction('index')
            ->render();
    }

}
