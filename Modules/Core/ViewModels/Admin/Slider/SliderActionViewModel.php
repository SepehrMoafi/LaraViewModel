<?php

namespace Modules\Core\ViewModels\Admin\Slider;

use Illuminate\Support\Facades\DB;
use Modules\Core\Entities\setting;
use Modules\Core\Entities\Slider;
use Modules\Core\ViewModels\BaseViewModel;
use function Psy\debug;

class SliderActionViewModel extends BaseViewModel
{
    public function __construct()
    {
        $this->theme_name = 'theme_admin';
    }

    public function create()
    {
        $this->modelData = new Slider();
        $data = [
            'view_model' => $this,
        ];
        return $this->renderView('core::slider.form' ,$data);
    }

    public function store($request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'params.des'=> '',
            'params.link'=> 'required',
            'type'=> 'required',
            'position'=> 'required',
            'src'=> 'mimes:png,jpg|max:2048',
            'sort'=> 'required',
        ]);
        return $this->saveService($validated , $request);

    }

    public function edit($request)
    {
        $this->modelData = Slider::find( $request->slider_id );
        $data = [
            'view_model' => $this,
        ];
        return $this->renderView('core::slider.form' ,$data);
    }

    public function update($request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'params.des'=> '',
            'params.link'=> 'required',
            'type'=> 'required',
            'position'=> 'required',
            'src'=> 'mimes:png,jpg|max:2048',
            'sort'=> 'required',
        ]);
        return $this->saveService($validated , $request);
    }

    public function saveService( $validData ,  $request)
    {
        try {
            DB::beginTransaction();

            $model = Slider::find( $request->slider_id ) ?? new Slider();

            $params = $model->params ? json_decode($model->params) : new \stdClass();
            foreach ($request['params'] as $key => $data){
                $params->$key = $data;
            }
            $model->params = json_encode($params);
            unset($validData['params']);
            $model->fill($validData);
            if ($request->src){
                $model->src = $this->uploadFile($request , 'src' , 'slider');
            }
            $model->save();
            DB::commit();

            alert()->success('با موفقیت انجام شد');
            return redirect(route('admin.core.sliders.index'));
        }catch (\Exception $e){

            DB::rollBack();
            if ( env('APP_DEBUG') ){
                alert()->error('مشکلی پیش آمد',$e->getMessage() );
            }else{
                alert()->error('مشکلی پیش آمد','مشکلی در ثبت اطلاعات وجود دارد لطفا موارد را برسی کنید و مجدد تلاش کنید .');
            }
            return redirect()->back()->withInput();

        }


    }

}
