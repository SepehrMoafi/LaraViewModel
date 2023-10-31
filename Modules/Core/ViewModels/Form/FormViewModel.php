<?php

namespace Modules\Core\ViewModels\Form;

use Modules\Core\Entities\Form;
use Modules\Core\ViewModels\BaseViewModel;

class FormViewModel extends BaseViewModel
{

    public function store()
    {
        $data = request()->input('config');
        $jsonData = json_encode($data);

        $form = new Form();
        $form->form = $jsonData;
        $form->save();
        alert()->toast('فرم با موفقیت ذخیره شد!', 'success');

        return redirect()->back();
    }
}
