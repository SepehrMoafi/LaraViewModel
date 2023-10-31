<?php

namespace Modules\User\ViewModels\Front\Address;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\User\Entities\Address;

class AddressDestroyViewModel extends BaseViewModel
{
    public function destroy()
    {
        try {
            DB::beginTransaction();

            $address = Address::query()->findOrFail(request()->model_id);
            $address->delete();

        } catch (\Exception $e) {
            DB::rollback();
            Log::critical('update address got an error ' . $e->getMessage());
            alert()->toast('مشکلی در بروزرسانی آدرس به وجود آمد', 'error');
            return redirect()->back();
        }
        DB::commit();
        alert()->toast('آدرس با موفقیت بروزرسانی شد', 'success');
        return redirect()->back();
    }


}
