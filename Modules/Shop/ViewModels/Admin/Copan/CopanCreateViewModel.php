<?php

namespace Modules\Shop\ViewModels\Admin\Copan;

use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\Copan;

class CopanCreateViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function create()
    {
        $this->modelData = new Copan();
        $data = [
            'view_model' => $this,
        ];
        return $this->renderView('shop::Copan.form' ,$data);
    }
}
