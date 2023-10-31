<?php

namespace Modules\Shop\ViewModels\Admin\Copan;

use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jenssegers\Date\Date;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\Copan;
use Morilog\Jalali\Jalalian;

class CopanStoreViewModel extends BaseViewModel
{
    public function store(): \Illuminate\Http\RedirectResponse
    {
        list($startedAt, $endedAt) = $this->generateDate();

//        dd(['started_at' => $startedAt, 'ended_at' => $endedAt]);
        $validation = request()->validate([
            'code' => 'required|string|max:255',
            'amount' => 'required|numeric',
//                'discount_ceiling' => 'nullable|numeric',
            'status' => 'required|integer',
            'allowed_number_of_uses' => 'nullable|integer',
//                'start_date' => 'required|date',
//                'end_date' => 'required|date|after:start_date',
            'first_buy' => 'required|boolean',
            'date' => 'required',
//                'amount_type' => 'required|in:0,1',
        ]);
        try {
            DB::beginTransaction();
            $coupon = new Copan();

            $validation['start_date'] = $startedAt;
            $validation['end_date'] = $endedAt;
            $validation['user_id'] = Auth::id();
            $coupon->fill($validation);
            $coupon->save();
        } catch (\Exception $exception) {
            DB::rollBack();
            alert()->error('مشکلی پیش آمده است');
            Log::critical('copan error is: ' . $exception->getMessage());
            return redirect()->back();
        }
        DB::commit();
        alert()->success('با موفقیت انجام شد');
        return to_route('admin.shop.copan.index');
    }

    /**
     * @return null[]
     */
    public function generateDate(): array
    {
        $dates = explode('-', request()->date);
        $startedAt = null;
        $endedAt = null;

        $currentYear = Jalalian::now()->getYear();
        $gregorianCurrentYearTime = Carbon::now()->year;

        foreach ($dates as $index => $date) {
            $parts = explode(' ', trim($date));
            $day = intval($parts[0]);
            $monthName = rtrim($parts[1], ',');

            (int)$parts[2] === $gregorianCurrentYearTime ? $year = $currentYear : $year = $parts[2];

            $monthMap = [
                'فروردین' => 1,
                'اردیبهشت' => 2,
                'خرداد' => 3,
                'تیر' => 4,
                'مرداد' => 5,
                'شهریور' => 6,
                'مهر' => 7,
                'آبان' => 8,
                'آذر' => 9,
                'دی' => 10,
                'بهمن' => 11,
                'اسفند' => 12,
            ];
            $month = $monthMap[$monthName];
            $jDate = (new Jalalian($year, $month, $day))->toCarbon()->toDateTimeString();

            if ($index === 0) {
                $startedAt = $jDate;
            } elseif ($index === 1) {
                $endedAt = $jDate;
            }
        }
        return array($startedAt, $endedAt);
    }
}
