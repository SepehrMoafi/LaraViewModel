<?php

namespace Modules\Core\Service\Finance;

use Modules\Core\Service\Finance\Functions\CreateFinanceDoc;
use Modules\Core\Service\Finance\Functions\CreateInventoryDoc;
use Modules\Core\Service\Finance\Functions\crmUsersCustomerRegister;
use Modules\Core\Service\Finance\Functions\GetProductList;
use Modules\Core\Service\Finance\Functions\GetProductPrice;
use Modules\Core\Service\Finance\Functions\login;

class TarazService
{
    use login , GetProductList , GetProductPrice ,crmUsersCustomerRegister ,CreateFinanceDoc , CreateInventoryDoc;
    private $user_name = 'admin';
    private $password = '1360';
    public $token;

    public $base_path = 'http://85.185.221.5:8585/tws';
    public function __construct()
    {
        $this->token = $this->login();
    }
}
