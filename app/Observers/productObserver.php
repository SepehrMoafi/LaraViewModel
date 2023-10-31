<?php

namespace App\Observers;

use Modules\Shop\Entities\Product;
use Modules\Shop\Entities\ProductCatalog;
use Modules\User\Entities\UserNotifyItem;

class productObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        if ($product->catalog){
            if($product->catalog->activeProducts->count() > 0 ){
                $most_notify = UserNotifyItem::where('item_type' , ProductCatalog::class)
                    ->where('item_id' , $product->catalog->id)
                    ->where('status' , 0)
                    ->get();
                foreach ($most_notify as $nt){
                    $nt->status = 1 ;
                    $nt->save();
                    //todo send sms
                }
            }
        }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
