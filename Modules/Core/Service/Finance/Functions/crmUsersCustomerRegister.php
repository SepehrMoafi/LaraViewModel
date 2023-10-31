<?php

namespace Modules\Core\Service\Finance\Functions;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\Core\Entities\ErrorLog;
use Modules\Shop\Entities\Order;

trait crmUsersCustomerRegister
{
    public function crmUsersCustomerRegister($user)
    {
        try {
            if (@ $user->api_id) {
                return $user;
            }
            $url = $this->base_path . "/tkt/customers";

            $headers = array(
                "accept: application/json",
                "Authorization: Bearer " . $this->token,
                "Content-Type: application/json"
            );
            $user_last = ' ';
            $androidUserPass = '12345678';
            $userLoginName = $user->email;
            $organizationID = '10000001';
            $customerPhoneNumber = $user->mobile;

            //$f_data = "{\"perComFName\":\"ali\",\"perComLName\":\"saleh\",\"userLoginName\":\"alisaleh\",\"androidUserPass\":\"12345678\",\"organizationID\":10000001,\"anyDeskID\":null,\"isOrganizationOwner\":false,\"isNotActive\":false,\"customerPhoneNumber\":\"09198950549\",\"userMobileNumber\":\"09198950549\",\"priorityID\":10000001,\"organizationalRank\":\"\",\"customerInternalNumber\":null,\"customerDesc\":\"\",\"accountExpirationDate\":\"1420/12/04\"}" ;
            $data = "{\"perComFName\":\"".$user->name."\",\"perComLName\":\"".$user_last."\",\"userLoginName\":\"".$userLoginName."\",\"androidUserPass\":\"".$androidUserPass."\",\"organizationID\":".$organizationID.",\"anyDeskID\":null,\"isOrganizationOwner\":false,\"isNotActive\":false,\"customerPhoneNumber\":\"".$customerPhoneNumber."\",\"userMobileNumber\":\"".$customerPhoneNumber."\",\"priorityID\":10000001,\"organizationalRank\":\"\",\"customerInternalNumber\":null,\"customerDesc\":\"\",\"accountExpirationDate\":\"1420/12/04\"}";

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
                    $res = json_decode($response);

                    $prams = $user->params_json;
                    $crm_res = new \stdClass();
                    $crm_res->status = 1;
                    $crm_res->res = $res;
                    $prams->sale_voucher = $crm_res;
                    $user->params = json_encode($prams);
                    $user->api_id = $res->customerID;

                    $user->save();
                    return $user;
                } else {
                    //fail
                    $error_log = new ErrorLog();
                    $error_log->description = 'در ثبت نام کاربر مشکلی پیش آمد';
                    $error_log->reason = 'crmUsersCustomerRegister';
                    $error_log->errorable_id = $user->id;
                    $error_log->errorable_type = User::class;
                    $error_log->params = $response;
                    $error_log->save();
                }
            } else {
                $error_log = new ErrorLog();
                $error_log->description = '  در ثبت نام کاربر مشکلی پیش آمد ۲';
                $error_log->reason = 'crmUsersCustomerRegister';
                $error_log->errorable_id = $user->id;
                $error_log->errorable_type = User::class;
                $error_log->save();

            }
            return null;

        } catch (\Exception $e) {
            $error_log = new ErrorLog();
            $error_log->description = $e->getMessage();
            $error_log->reason = 'crmUsersCustomerRegister';
            $error_log->errorable_id = $user->id;
            $error_log->errorable_type = User::class;
            $error_log->save();
            return null;
        }
    }
}
