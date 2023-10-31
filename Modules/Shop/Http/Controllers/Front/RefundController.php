<?php

namespace Modules\Shop\Http\Controllers\Front;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class RefundController
{
    public function __invoke($model_id,Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['item_id' => $model_id ] )
            ->setViewModel('front.refund.refund')
            ->setAction('refund')
            ->render();
    }
}
