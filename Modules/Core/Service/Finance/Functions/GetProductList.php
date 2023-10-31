<?php

namespace Modules\Core\Service\Finance\Functions;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\Core\Entities\ErrorLog;

trait GetProductList
{
    public function getProductList($goodsCode = 0 )
    {
        try {
            $today = jdate()->format('d/m/Y');
            if ($goodsCode){

                $response = Http::withToken($this->token)->get($this->base_path.'/sale/goods', [
                    'voucherDate'=>$today,
                    'voucherTypeID'=>'6000',
                    'goodsCode' =>$goodsCode,
                    'storeID' => '10000001',
                ]);
            }else{
                $response = Http::withToken($this->token)->get($this->base_path.'/sale/goods', [
                    'voucherDate'=>$today,
                    'voucherTypeID'=>'6000',
                    'storeID' => '10000001',
                ]);
            }

            if ($response->successful()){
                $res = json_decode( $response->body() );
                return $res;
            }

            $error_log = new ErrorLog();
            $error_log->description = 'در دریافت اطلاعات محصول مشکلی پیش آمد';
            $error_log->reason = 'getProductList';
            $error_log->save();

            Log::error( 'taraz:getProductList:'.$response->body() );
            return null;

        }catch (\Exception $e){
            $error_log = new ErrorLog();
            $error_log->description = $e->getMessage();
            $error_log->reason = 'getProductList';
            $error_log->save();
            return null;
        }
    }
}
