<?php

namespace Modules\Shop\ViewModels\Admin\LuckyWheel;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Core\Trait\GridTrait;
use Modules\Core\ViewModels\BaseViewModel;
use Modules\Shop\Entities\Copan;
use Modules\Shop\Entities\Gift;
use Modules\Shop\Entities\GiftItem;
use Modules\Shop\Entities\ProductCatalog;
use Modules\Shop\Entities\UserGift;
use Morilog\Jalali\Jalalian;
use function Modules\Blog\ViewModels\Admin\Post\mb_substr;
use function PHPUnit\Framework\isEmpty;

class LuckyWheelViewModel extends BaseViewModel
{
    use GridTrait;

    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function setGridData($is_export = false)
    {
        $query = Gift::query();
        if ($is_export) {
            $this->rows = $query;
        } else {
            $this->rows = $query->paginate(40);
        }
        return $this;
    }

    public function setColumns()
    {
        $this->addColumn([
            'name' => 'id',
            'title' => 'شماره سفارش',
        ]);

        $this->addColumn([
            'name' => 'title',
            'title' => 'عنوان',
        ]);

        $this->addColumn([
            'name' => 'active_date',
            'title' => 'تاریخ شروع',
        ]);

        $this->addColumn([
            'name' => 'expire_date',
            'title' => 'تاریخ پایان',
        ]);


        $this->addColumn([
            'name' => 'maximum_use',
            'title' => 'حداکثر استفاده',
        ]);

        $this->addColumn([
            'name' => 'product_catalog_id',
            'title' => 'محصول',
        ]);

        /*** actions ***/
        $this->addAction([
            'name' => 'edit',
            'title' => 'ویرایش',
            'url' => array(
                'name' => 'admin.shop.luckyWheel.edit',
                'parameter' => ['id'],
                'method' => 'get',
            ),
            'class' => 'btn-warning',
        ]);

        $this->addAction([
            'name' => 'delete',
            'title' => 'حذف',
            'url' => array(
                'name' => 'admin.shop.luckyWheel.destroy',
                'parameter' => ['id'],
                'method' => 'delete',
            ),
            'class' => 'btn-danger',
        ]);

        /*** buttons ***/


        /*** buttons ***/
        $this->addButton([
            'name' => 'addNew',
            'title' => 'افزودن جدید',
            'url' => route('admin.shop.luckyWheel.create'),
            'class' => 'btn-primary',
        ]);


        $this->can_export = true;
        return $this;
    }

    public function create()
    {
        $products = ProductCatalog::all();
        $copans = Copan::query()
            ->whereNull('deleted_at')
            ->where('allowed_number_of_uses', '>', 0)
            ->where('end_date', '>=', Carbon::now())
            ->get();
        $data = [
            'products' => $products,
            'copans' => $copans
        ];
        return $this->renderView('shop::luckyWheel.create_form', $data);
    }

    public function store()
    {
        list($startedAt, $endedAt) = $this->generateDate();

        $validation = request()->validate([
            'title' => 'required|string',
            'product_catalog_id' => 'required|integer|exists:product_catalogs,id',
            'products.*' => 'integer|exists:products,id',
            'discount_code.*' => 'integer|exists:copans,id',
            'maximum_use' => 'required|integer',
            'date' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $gift = new Gift();

            $validation['active_date'] = $startedAt;
            $validation['expire_date'] = $endedAt;

            $gift->fill($validation);
            $gift->save();

            if (!key_exists('products',$validation) && !key_exists('discount_code',$validation)){
                alert()->toast('حداقل ۳ مورد برای گردانه شانس انتخاب کنید.','error');
                return redirect()->back();
            }

            if (key_exists('products',$validation)){
                foreach ($validation['products'] as $product) {
                    $item = ProductCatalog::findOrFail($product)->giftItems()->create([
                        'gift_id' => $gift->id
                    ]);
                }
            }

            if (key_exists('discount_code',$validation)){
                foreach ($validation['discount_code'] as $discount) {
                    $item = Copan::findOrFail($discount)->giftItems()->create([
                        'gift_id' => $gift->id
                    ]);
                }
            }

        } catch (\Exception $exception) {
            alert()->error('مشکلی پیش آمده است');
            Log::critical('copan error is: ' . $exception->getMessage());
            return redirect()->back();
        }
        DB::commit();
        alert()->success('گردونه با موفقیت ایجاد شد');
        return to_route('admin.shop.luckyWheel.index');
    }

    public function edit()
    {
        $gift = Gift::query()->findOrFail(request()->model_id);
        $products = ProductCatalog::query()->whereNull('deleted_at')->get();
        $copans = Copan::query()
            ->whereNull('deleted_at')
            ->where('allowed_number_of_uses', '>', 0)
            ->where('end_date', '>=', Carbon::now())
            ->get();

        $giftItems = GiftItem::whereHasMorph(
            'itemable',
            [Copan::class, ProductCatalog::class],
            function (Builder $query) use ($gift) {
                $query->where('gift_id', $gift->id);
            }
        )->get();
        $data = [
            'gift' => $gift,
            'giftItems' => $giftItems,
            'products' => $products,
            'copans' => $copans
        ];
        return $this->renderView('shop::luckyWheel.edit_form', $data);
    }

    public function update()
    {
        list($startedAt, $endedAt) = $this->generateDate();

        $validation = request()->validate([
            'title' => 'required|string',
            'product_catalog_id' => 'required',
            'products.*' => '',
            'discount_code.*' => '',
            'maximum_use' => 'nullable|integer',
            'date' => 'required',
        ]);

        if (!key_exists('products',$validation) && !key_exists('discount_code',$validation)){
            alert()->toast('حداقل ۳ مورد برای گردانه شانس انتخاب کنید.','error');
            return redirect()->back();
        }

        try {
            DB::beginTransaction();
            $gift = Gift::query()->findOrFail(request()->model_id);
            if (UserGift::query()->where('gift_id',$gift->id)->count() !== 0){
                alert()->toast('امکان بروز رسانی وجود ندارد ، زیرا کاربری از این گردانه آیتمی برنده شده است','error');
                return redirect()->back();
            }

            $validation['active_date'] = $startedAt;
            $validation['expire_date'] = $endedAt;

            $gift->fill($validation);
            $gift->save();
            if (isset($validation['products'])) {
                GiftItem::query()->where('itemable_type', 'Modules\Shop\Entities\ProductCatalog')->where('gift_id', $gift->id)->delete();
                foreach ($validation['products'] as $product) {
                    $item = ProductCatalog::findOrFail($product)->giftItems()->create([
                        'gift_id' => $gift->id
                    ]);
                }
            } else {
                GiftItem::query()->where('itemable_type', 'Modules\Shop\Entities\ProductCatalog')->where('gift_id', $gift->id)->delete();
            }

            if (isset($validation['discount_code'])) {
                GiftItem::query()->where('itemable_type', 'Modules\Shop\Entities\Copan')->where('gift_id', $gift->id)->delete();
                foreach ($validation['discount_code'] as $discount) {
                    $item = Copan::findOrFail($discount)->giftItems()->create([
                        'gift_id' => $gift->id
                    ]);
                }
            } else {
                GiftItem::query()->where('itemable_type', 'Modules\Shop\Entities\Copan')->where('gift_id', $gift->id)->delete();
            }


        } catch (\Exception $exception) {
            alert()->error('مشکلی پیش آمده است');
            Log::critical('copan error is: ' . $exception->getMessage());
            return redirect()->back();
        }
        DB::commit();
        alert()->success('گردونه با موفقیت بروزرسانی شد');
        return to_route('admin.shop.luckyWheel.index');
    }

    public function destroy()
    {
        try {
            DB::beginTransaction();
            $gift = Gift::query()->findOrFail(request()->model_id);
            if (UserGift::query()->where('gift_id',$gift->id)->count() !== 0){
                alert()->toast('امکان حذف وجود ندارد ، زیرا کاربری از این گردانه آیتمی برنده شده است','error');
                return redirect()->back();
            }
            GiftItem::query()->where('itemable_type', 'Modules\Shop\Entities\ProductCatalog')->where('gift_id', $gift->id)->delete();
            GiftItem::query()->where('itemable_type', 'Modules\Shop\Entities\Copan')->where('gift_id', $gift->id)->delete();
            $gift->delete();
        } catch (\Exception $exception) {
            DB::rollBack();
            alert()->error('مشکلی پیش آمده است');
            Log::critical($exception->getMessage());
            return redirect()->back();
        }
        DB::commit();
        alert()->success('با موفقیت پاک شد');
        return redirect()->back();

    }


    public function getRowUpdate($row)
    {
        $row->user_name = $row->user->name ?? '-';
        $row->active_date = jdate($row->active_date)->format('Y/m/d');
        $row->expire_date = jdate($row->expire_date)->format('Y/m/d');
        $row->product_catalog_id = $row->productCatalog->title ?? '-';

        return $row;
    }

    public function getActionUpdate($actions, $row)
    {
        return $actions;
    }

    public function showGrid()
    {
        return $this->setGridData()->setColumns()->renderGridView();
    }

    public function getRowExportUpdate($row)
    {
        $res = new Collection(
            [
                'id' => $row->id,
                'created_at' => jdate($row->created_at)->format('Y-m-d H:i'),

                'amount' => $row->amount,
                'payable_amount' => $row->payable_amount,
                'user_name' => $row->user->name ?? '-',
                'status' => $row->status ?? '0',
            ]
        );
        return $res;
    }

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
