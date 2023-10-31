<?php


namespace Modules\Shop\Service\Payment\Mellat;

use SoapClient;


class BankMellatPayment
{
    protected $soapClient;
    protected $wsdl;
    public $config;
    public $callBackURL;

    public function __construct()
    {
       $config= [

            'wsdl' => env('BANK_MELLAT_WSDL', 'https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl'),
            'operationServer' => env('BANK_MELLAT_OPERATION_SERVER', 'https://bpm.shaparak.ir/pgwchannel/startpay.mellat'),
            'userName' =>'Arshahamrah110',
            'userPassword' =>'26630348',
            'terminalId' =>'6547305',
//           'userName' =>'2659557',
//           'userPassword' =>'Arash1358',
//           'terminalId' =>'6547305',

           'callBackURL' => '' , //route('school.user.bank_callback'),

        ];
        $this->config = $config;
        $this->callBackURL = $this->config['callBackURL'];
    }

    /**
     * Payment Request
     * @param $amount - IRR
     * @param $orderId - INT
     * @param string $additionalData
     * @param int $payerId
     * @return array
     * @throws \Exception
     */
    public function paymentRequest($amount, $orderId, $additionalData = '', $payerId = 0 , $callBackURL)
    {

        $wsdl = $this->config['wsdl'];
        $this->soapClient = new SoapClient($wsdl);
        if($amount && $amount > 100 && $orderId ) {
            $parameters = [
                'terminalId' => $this->config['terminalId'],
                'userName' => $this->config['userName'],
                'userPassword' => $this->config['userPassword'],
                'orderId' => $orderId,
                'amount' => $amount,
                'localDate' => date("Ymd"),
                'localTime' => date("His"),
                'additionalData' => $additionalData,
                'callBackUrl' => $callBackURL,
                'payerId' => $payerId
            ];

            try {
                // Call the SOAP method
                $result = $this->soapClient->bpPayRequest($parameters);
                // Display the result
                $res = explode(',', $result->return);

                if ($res[0] == "0") {
                    return [
                        'result' => true,
                        'res_code' => $res[0],
                        'ref_id' => $res[1]
                    ];
                } else {
                    return [
                        'result' => false,
                        'res_code' => $res[0],
                        'ref_id' => isset($res[1]) ? $res[1] : null
                    ];
                }
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
    }

    /**
     * Verify Payment
     * @param $orderId
     * @param $saleOrderId
     * @param $saleReferenceId
     * @return mixed - false for failed
     */
    public function verifyPayment($orderId, $saleOrderId, $saleReferenceId)
    {

        $wsdl=$this->config['wsdl'];
        $this->soapClient = new SoapClient($wsdl);

        if($orderId && $saleOrderId && $saleReferenceId) {

            $parameters = [
                'terminalId' => $this->config['terminalId'],
                'userName' => $this->config['userName'],
                'userPassword' => $this->config['userPassword'],
                'orderId' => $orderId,
                'saleOrderId' => $saleOrderId,
                'saleReferenceId' => $saleReferenceId,
            ];

            try {
              //  throw new \Exception('tst-fail-verifyPayment');
//                throw new \Exception('tst');
                // Call the SOAP method
               return $this->soapClient->bpVerifyRequest($parameters);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        } else
            return false;
    }
    public function checkPayment($orderId, $saleOrderId, $saleReferenceId)
    {
        $wsdl=$this->config['wsdl'];
        $this->soapClient = new SoapClient($wsdl);

        if($orderId && $saleOrderId && $saleReferenceId) {

            $parameters = [
                'terminalId' => $this->config['terminalId'],
                'userName' => $this->config['userName'],
                'userPassword' => $this->config['userPassword'],
                'orderId' => $orderId,
                'saleOrderId' => $saleOrderId,
                'saleReferenceId' => $saleReferenceId,
            ];

            try {

                // Call the SOAP method
                return $this->soapClient->bpInquiryRequest($parameters);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        } else
            return false;
    }
    public function settlePayment($orderId, $saleOrderId, $saleReferenceId)
    {
        $wsdl=$this->config['wsdl'];
        $this->soapClient = new SoapClient($wsdl);

        if($orderId && $saleOrderId && $saleReferenceId) {

            $parameters = [
                'terminalId' => $this->config['terminalId'],
                'userName' => $this->config['userName'],
                'userPassword' => $this->config['userPassword'],
                'orderId' => $orderId,
                'saleOrderId' => $saleOrderId,
                'saleReferenceId' => $saleReferenceId,
            ];

            try {
             //   throw new \Exception('tst-fail-settlePayment');
                // Call the SOAP method
                return $this->soapClient->bpSettleRequest($parameters);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        } else
            return false;
    }

    public function reversalPayment($orderId, $saleOrderId, $saleReferenceId)
    {
        $wsdl=$this->config['wsdl'];
        $this->soapClient = new SoapClient($wsdl);

        if($orderId && $saleOrderId && $saleReferenceId) {

            $parameters = [
                'terminalId' => $this->config['terminalId'],
                'userName' => $this->config['userName'],
                'userPassword' => $this->config['userPassword'],
                'orderId' => $orderId,
                'saleOrderId' => $saleOrderId,
                'saleReferenceId' => $saleReferenceId,
            ];

            try {

                // Call the SOAP method
                return $this->soapClient->bpReversalRequest($parameters);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        } else
            return false;
    }

    public function postRefId($ref_id,$mobile='')
    {
        $send_to_bank_message = trans('sale::online.send_to_bank');
            echo '<form  id="sendToBank" action="https://bpm.shaparak.ir/pgwchannel/startpay.mellat" method="POST">'.$send_to_bank_message.'
					<input type="hidden" id="RefId" name="RefId" value="'. $ref_id .'">
					<input type="hidden" id="MobileNo" name="MobileNo" value="'. $mobile .'">
				</form>
				<script type="text/javascript">document.getElementById("sendToBank").submit();</script>';
            exit;
//        return view('school::finance.send_to_bank',['ref_id'=>$refIdValue,'mobile'=>$mobile]);

    }
}
