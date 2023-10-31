<?php

namespace Modules\Core\Service\Finance\Functions;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\Core\Entities\ErrorLog;
use Modules\Shop\Entities\Order;

trait CreateInventoryDoc
{
    public function CreateInventoryDoc ($data , $order){
        try {
            if (@ $order->params_json->inv_voucher->status == 1 ){
                return $order ;
            }

            $url = $this->base_path."/inv/vouchers";
            $headers = array(
                "accept: application/json",
                "Authorization: Bearer ".$this->token,
                "Content-Type: application/json"
            );
            //$f_data = "{\"header\":{\"voucherTypeID\":6001,\"customerID\":10000003,\"salesManID\":10000003,\"marketingManID\":10000003,\"dayCount\":15,\"storeID\":10000001,\"saleCenterID\":10000001,\"deliverCenterID\":10000002,\"voucherDesc\":null,\"paymentWayID\":28},\"other\":{},\"details\":[{\"goodsID\":10000561,\"secUnitID\":null,\"quantity\":1,\"fee\":5490000,\"detailXDesc\":null}],\"promotions\":[],\"elements\":[]}" ;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);

            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($response) {
                if ($httpcode == '200') {
                    $res = json_decode( $response );

                    $order_prams = $order->params_json ;
                    $inv_voucher = new \stdClass();
                    $inv_voucher->status = 1 ;
                    $inv_voucher->res = $res;
                    $order_prams->inv_voucher = $inv_voucher;
                    $order->params = json_encode($order_prams);
                    $order->api_status = 2 ;
                    $order->save();
                    return $order;
                }else {
                    //fail
                    $error_log = new ErrorLog();
                    $error_log->description = 'در ثبت سند انبار مشکلی پیش آمد';
                    $error_log->reason = 'CreateInventoryDoc';
                    $error_log->errorable_id = $order->id;
                    $error_log->errorable_type = Order::class;
                    $error_log->params = $response;
                    $error_log->save();
                }
            } else {
                $error_log = new ErrorLog();
                $error_log->description = '  در ثبت سند انبار مشکلی پیش آمد ۲';
                $error_log->reason = 'CreateInventoryDoc';
                $error_log->errorable_id = $order->id;
                $error_log->errorable_type = Order::class;
                $error_log->save();
            }
            return null;
        }catch (\Exception $e){
            $error_log = new ErrorLog();
            $error_log->description = $e->getMessage();
            $error_log->reason = 'CreateInventoryDoc';
            $error_log->errorable_id = $order->id;
            $error_log->errorable_type = Order::class;
            $error_log->save();
            return null;
        }
    }
}
