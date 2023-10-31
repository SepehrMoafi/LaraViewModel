<?php

namespace Modules\User\Trait;

use App\Models\User;
use Modules\Core\Service\Finance\TarazService;
use Modules\Shop\Entities\Product;

trait orderTaraz
{
    public function syncOrder( $model) :bool
    {
        if ( isset($model) ){
            $taraz_service = new TarazService();

            $customer = User::find($model->user_id);
            if (! $customer->api_id ){
                $crm_user = $taraz_service->crmUsersCustomerRegister($customer);
                if (! $crm_user->api_id){
                    // we have problem with registering user
                    return false;
                }else{
                    $customer = $crm_user;
                }
            }

            $order_items = $model->order_items->where('item_type' , Product::class );
            //$details = "[{\"goodsID\":10000561,\"secUnitID\":null,\"quantity\":1,\"fee\":5490000,\"detailXDesc\":null}]";
            $details = "[";
            $res_order_items = [];
            foreach ( $order_items as $key => $order_item ) {
                if ($key === $order_items->keys()->last() ) {
                    $prp = "{\"goodsID\":".$order_item->ItemObj->good_id.",\"secUnitID\":null,\"quantity\":".$order_item->qty.",\"fee\":".$order_item->amount.",\"detailXDesc\":null}";
                }else{
                    $prp = "{\"goodsID\":".$order_item->ItemObj->good_id.",\"secUnitID\":null,\"quantity\":".$order_item->qty.",\"fee\":".$order_item->amount.",\"detailXDesc\":null},";
                }
                //$prp = "{\"goodsID\":10000561,\"secUnitID\":null,\"quantity\":1,\"fee\":5490000,\"detailXDesc\":null}";
                //  "feeAgreement" => $order_item->total_amount,
                //  "feeDiscountPrice"=> $order_item->discount_amount,
                $details.= $prp;
            }
            $details .= "]";

            $voucherTypeID = 6004;
            $customerID = $customer->api_id;
            $salesManID = 10000003;
            $marketingManID = 10000003;
            $dayCount = 1;
            $storeID = 10000001;
            $saleCenterID = 10000003;
            $deliverCenterID = 10000002;
            $voucherDesc = 'null';
            $paymentWayID = 28;

            $saleVoucher_data = "{\"header\":{\"voucherTypeID\":".$voucherTypeID.",\"customerID\":".$customerID.",\"salesManID\":".$salesManID.",\"marketingManID\":".$marketingManID.",\"dayCount\":".$dayCount.",\"storeID\":".$storeID.",\"saleCenterID\":".$saleCenterID.",\"deliverCenterID\":".$deliverCenterID.",\"voucherDesc\":".$voucherDesc.",\"paymentWayID\":".$paymentWayID."},\"other\":{},\"details\":".$details.",\"promotions\":[],\"elements\":[]}" ;
            $saleVoucher =  $taraz_service->CreateFinanceDoc($saleVoucher_data , $model );

            if ( ! $saleVoucher){
                // we have problem with create saleVoucher
                return false;
            }

            $invVoucher_data = "{\"header\":{\"voucherTypeID\":".$voucherTypeID.",\"storeID\":".$storeID.",\"tafsiliID\":null,\"voucherDesc\":null,\"voucherDate\":null},\"details\":".$details."}" ;
            $invVoucher =  $taraz_service->CreateInventoryDoc($invVoucher_data , $model );
            if ( ! $invVoucher){
                // we have problem with create invVoucher
                return false;
            }

            // is successful
            return true;
        }
        // order not found
        return false ;
    }
}
