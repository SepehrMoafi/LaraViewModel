<?php

namespace Modules\Sale\Libraries\Payment\Online\Payments\Mellat;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Modules\Sale\Libraries\Payment\Online\Payments\OnlineTemplate;
use Modules\Sale\Models\Payment;

class Mellat extends OnlineTemplate
{


    public $code = 'mellat';

    public $config = [
        'wsdl' =>'https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl',
        'operationServer'=>'https://bpm.shaparak.ir/pgwchannel/startpay.mellat',
        'mellat_currency' => 'IRR',
        'userName' =>'Arshahamrah110',
        'userPassword' =>'26630348',
        'terminalId' =>'6547305',
//        'callBackURL' => route('school.bank_callback'),

    ];


    public $instanceConfig = [
        'ltms' => [
//            'zarin_merchant_id' => '548747b8-f91a-11e6-a4e0-005056a205be',
            'mellat_currency' => 'IRT',
//            'zarin_get_url' => 'https://www.zarinpal.com/pg/services/WebGate/wsdl',
//            'zarin_pay_url' => 'https://www.zarinpal.com/pg/StartPay/',
//            'zarin_extra_url' => '/ZarinGat',
        ]
    ];
    protected $is_active = true;


    /**
     * @return array|bool
     */
    public function getOptions()
    {
        if ($this->is_active) {
            return [
                "option" => ["payment" => $this->code, "name" => trans("sale::payment." . $this->code), 'image' => get_instance()->getCurrentUrl(url('/assets/img/icon/zarin-pal.png'))]
            ];
        }
        return false;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /** STEP 5 - payment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View|mixed|string
     * @throws \SoapFault
     */
    public function getPaymentRedirectPage()
    {

        try{
            $Amount = $this->payment->amount;
            $CallbackURL = $this->getCallBack();
            $payment_id = $this->payment->id ;
            $order_id = $this->payment->action_id ;

            $mellat_get_way = new BankMellatPayment();
            $config= [
                'wsdl' => env('BANK_MELLAT_WSDL', 'https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl'),
                'operationServer' => env('BANK_MELLAT_OPERATION_SERVER', 'https://bpm.shaparak.ir/pgwchannel/startpay.mellat'),
                'userName' =>'Arshahamrah110',
                'userPassword' =>'26630348',
                'terminalId' =>'6547305',
                'callBackURL' => $this->getCallBack(),

            ];
            $mellat_get_way->config = $config;

            $mellat_get_way->callBackURL = $CallbackURL;
            $mobile = auth()->user()->mobile;

            $res = $mellat_get_way->paymentRequest( $Amount, $order_id, '', auth()->user()->id );
            Log::channel('online_pay')->info('send-to-bank', ['order_id' => $order_id, 'p-order-id' => $payment_id, '$res' => $res]);
            $result = @$res['result'];
            $res_code = @$res['res_code'];
            $ref_id = @$res['ref_id'];
            if ($ref_id && $result) {
                $return_bank_message['paymentRequest'] = $res;
                $this->payment->request_id = $res['ref_id'];
                $this->payment->state = $this->getPaymentSendState();
                $this->updateTransaction();
                //send to bank and exit
                $res = $mellat_get_way->postRefId($ref_id, $mobile);
            }else{
                $this->payment->state = $this->getPaymentErrorState();
                $this->updateTransaction();
                return $this->getErrorBox($res);
            }

        }catch (\Throwable $exception){
            dd($exception);
            report($exception);
            return abort(500, $exception->getMessage());
        }

    }


    public function getPaymentVerify()
    {
        if (in_array($this->payment->state, $this->getPaymentSuccessStates())) {
            return $this->payment;
        }
        $currentState = $this->payment->state;

        $return_bank_message = [];
        $mellat_get_way = new BankMellatPayment();
        $orderId = request('orderId') ?? request('SaleOrderId');
        $ref_id = request('RefId');
        $SaleOrderId = request('SaleOrderId');
        $SaleReferenceId = request('reference_code');

        Log::channel('online_pay')->info('callback', ['$orderId' => $orderId, '$ref_id' => $ref_id, '$SaleOrderId' => $SaleOrderId, '$SaleReferenceId' => $SaleReferenceId,]);

        //verify-transaction
        $mellat_get_way->verifyPayment($SaleOrderId, $SaleOrderId, $SaleReferenceId);

        //settle-transaction
        $settle_payment_result = $mellat_get_way->settlePayment($SaleOrderId, $SaleOrderId, $SaleReferenceId);

        if ((isset($settle_payment_result->return)) && ((@$settle_payment_result->return == 45) || ($settle_payment_result->return == 0))) {
            $this->payment->state = $this->getPaymentSuccessState();
            $this->payment->reference_id = $ref_id;
        } else {
            $this->payment->state = $this->getPaymentFailState();
        }

        if ($currentState != $this->payment->state) {
            $this->updateTransaction();
        }

        if (in_array($this->payment->state, $this->getPaymentSuccessStates())) {
            return $this->payment;
        }
        return false;

    }


    public function getConfig($name)
    {
        if (isset($this->instanceConfig[$this->getInstanceName()])) {
            return $this->instanceConfig[$this->getInstanceName()][$name];
        }
        return $this->config[$name];
    }


    public function canPaymentRevalidate()
    {
        if (in_array($this->payment->state, $this->getPaymentSuccessStates())) {
            return false;
        }
        return true;
    }


    public function getPaymentRevalidate()
    {
        if ($this->canPaymentRevalidate()) {
            return $this->setRevalidate(true)->getPaymentVerify();
        }
        return false;
    }

}
