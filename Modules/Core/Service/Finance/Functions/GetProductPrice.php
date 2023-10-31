<?php

namespace Modules\Core\Service\Finance\Functions;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait GetProductPrice
{
    public function getProductPrice($p_id)
    {
        try {

            $response = Http::withToken($this->token)->get($this->base_path.'/sale/pricelistdetails', [
               // 'goodsID'=>$p_id
            ]);

            if ($response->successful()){
                $res = json_decode( $response->body() );
                return $res;
            }

            Log::error( 'taraz:getProductList:'.$response->body() );
            return null;

        }catch (\Exception $e){
            Log::error( 'taraz:getProductList:'.$e->getMessage() );
            return null;
        }
    }
}
