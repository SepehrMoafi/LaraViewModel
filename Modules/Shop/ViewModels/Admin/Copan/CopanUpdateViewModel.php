<?php

namespace Modules\Shop\ViewModels\Admin\Copan;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Core\Entities\RouteBlock;
use Modules\Core\Trait\GridTrait;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\Copan;
use Modules\User\Entities\Address;

class CopanUpdateViewModel extends BaseViewModel
{
    public function update()
    {

        try {

            DB::beginTransaction();

            $validatedData = request()->validate([
                'code' => 'required|string|max:255',
                'amount' => 'required|numeric',
//                'discount_ceiling' => 'nullable|numeric',
                'status' => 'required|integer',
                'allowed_number_of_uses' => 'nullable|integer',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'first_buy' => 'required|boolean',
//                'amount_type' => 'required|in:0,1',
            ]);
            $copan = Copan::query()->findOrFail(request()->model_id);
            $validatedData['user_id']= Auth::id();
            $copan->fill($validatedData);
            $copan->save();
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
