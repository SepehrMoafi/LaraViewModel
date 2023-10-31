<?php

namespace Modules\Shop\Http\Controllers\Front;

use Illuminate\Http\Request;
use Modules\Core\ViewModels\MasterViewModel;

class LuckyWheel
{
    public function show($model_id,Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('front.luckyWheel.LuckyWheel')
            ->setAction('show')
            ->render();
    }

    public function win($model_id,Request $request , MasterViewModel $masterViewModel)
    {
        return $masterViewModel
            ->setModule('Shop')
            ->setRequest( $request , ['model_id' => $model_id ] )
            ->setViewModel('front.luckyWheel.LuckyWheel')
            ->setAction('win')
            ->render();
    }
}
