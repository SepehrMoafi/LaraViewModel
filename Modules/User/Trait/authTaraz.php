<?php

namespace Modules\User\Trait;

use App\Models\User;
use Modules\Core\Service\Finance\TarazService;

trait authTaraz
{
    public function registerCustomer( array $data)
    {

        if ( isset( $data['email'] ) ){
            $user = User::where('email' ,$data['email'] )->first();
        }

        if ( isset($user) ){
            $taraz_service = new TarazService();
            $res =  $taraz_service->crmUsersCustomerRegister( $user);
        }

    }
}
