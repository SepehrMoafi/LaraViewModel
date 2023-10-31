<?php

namespace Modules\User\ViewModels\Front\Address;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\User\Entities\Address;

class AddressUpdateViewModel extends BaseViewModel
{
    public function update()
    {
        try {

            DB::beginTransaction();

            $validatedData = request()->validate([
                'user_id' => 'required',
                'address' => 'required',
                'name' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'state' => 'required',
                'city' => 'required',
            ]);
            $userAddress = Address::query()->findOrFail(request()->model_id);
            $userAddress->fill($validatedData);
            $userAddress->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical('update address got an error ' . $e->getMessage());
            alert()->toast( 'مشکلی در بروزرسانی آدرس به وجود آمد' , 'error' );
            return redirect()->back();
        }
        DB::commit();
        alert()->toast( 'آدرس با موفقیت بروزرسانی شد' , 'success' );
        return redirect()->back();
    }

}
