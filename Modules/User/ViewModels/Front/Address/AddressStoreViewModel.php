<?php

namespace Modules\User\ViewModels\Front\Address;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\User\Entities\Address;

class AddressStoreViewModel extends BaseViewModel
{
    public function store()
    {
        try {
            DB::beginTransaction();

            $validatedData = request()->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'state' => 'required|integer',
                'city' => 'required|integer',
            ]);

            $validatedData['user_id']=\Auth::id();
            $userAddress = new Address();
            $userAddress->fill($validatedData);
            $userAddress->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical('add address got an error ' . $e->getMessage());
            alert()->toast('ذحیره اطلاعات با مشکل مواجه شد .','warning' );
            return redirect()->back();

        }
        DB::commit();
        alert()->toast('آدرس با موفقیت ثبت شد', 'success');
        return redirect()->back();
    }

}
