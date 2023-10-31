<?php

namespace Modules\Core\ViewModels\Admin\Setting;

use Illuminate\Support\Facades\DB;
use Modules\Core\Entities\Setting;
use Modules\Core\ViewModels\BaseViewModel;
use function Psy\debug;

class MainSettingViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function getSettingDataObject()
    {
        return Setting::where('code', '1025')->first();
    }

    public function showForm()
    {
        $this->modelData = $this->getSettingDataObject();
        $data = [
            'view_model' => $this,
        ];
        return $this->renderView('core::setting.main_setting', $data);
    }

    public function save($request)
    {
        $validated = $request->validate([
            'site_title' => 'required|max:255',
            'site_logo' => '',
            'site_mobile'=>'',
            'site_mobileNumber'=>'',
            'footer_text'=>'',
        ]);

        try {
            DB::beginTransaction();

            $setting = Setting::whereCode('1025')->first() ?? new Setting();
            $main_setting = $setting->main_setting ? json_decode($setting->main_setting) : new \stdClass();

            foreach ($validated as $key => $data) {
                $main_setting->$key = $data;
            }
            if ($request->site_logo){
                $main_setting->site_logo = $this->uploadFile($request,'site_logo','setting');
            }
            $setting->code = '1025';
            $setting->main_setting = json_encode($main_setting);
            $setting->save();
            DB::commit();

            alert()->success('با موفقیت انجام شد');
            return redirect()->back();
        } catch (\Exception $e) {

            DB::rollBack();
            if (env('APP_DEBUG')) {
                alert()->error('مشکلی پیش آمد', $e->getMessage());
            } else {
                alert()->error('مشکلی پیش آمد', 'مشکلی در ثبت اطلاعات وجود دارد لطفا موارد را برسی کنید و مجدد تلاش کنید .');
            }
            return redirect()->back()->withInput();

        }


    }

}
