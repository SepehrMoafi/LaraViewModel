@extends('core::theme_admin.layouts.app')

@section('content')
    <div class="content">

        <form action="{{ route('admin.core.setting.main-setting-save') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                <h2 class="text-lg font-medium ml-auto">
                     تنظیمات اصلی
                </h2>

                <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                        <button class=" mr-2 btn btn-primary shadow-md flex items-center" aria-expanded="false" type="submit"> ذخیره </button>
                </div>
            </div>
            <div style="background: white;padding: 10px" class="pos intro-y grid grid-cols-12 gap-5 mt-5">
                <!-- BEGIN: Post Content -->
                <div  class="intro-y col-span-12 lg:col-span-12">

                    <div>
                        <div class="sm:grid grid-cols-1 gap-2">

                            <div class="mt-3">
                                <label for="crud-form-1" class="form-label">عنوان سایت</label>
                                <input name="site_title" id="crud-form-3" type="text" class="form-control w-full {{$errors->has('site_title') ? 'is-danger' :''}}" value="{{old( 'site_title' , $view_model->getModelDataJson('main_setting_json.site_title') )}}" placeholder="">
                                @error('site_title')
                                    <div class="alert-danger-soft">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-3">
                                <label for="crud-form-1" class="form-label">شماره موبایل برای سایت</label>
                                <input name="site_mobileNumber" id="crud-form-3" type="text" class="form-control w-full {{$errors->has('site_mobileNumber') ? 'is-danger' :''}}" value="{{old( 'site_mobileNumber' , $view_model->getModelDataJson('main_setting_json.site_mobileNumber') )}}" placeholder="">
                                @error('site_mobileNumber')
                                <div class="alert-danger-soft">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-3">
                                <label for="crud-form-1" class="form-label">شماره سایت</label>
                                <input name="site_mobile" id="crud-form-3" type="text" class="form-control w-full {{$errors->has('site_mobile') ? 'is-danger' :''}}" value="{{old( 'site_mobile' , $view_model->getModelDataJson('main_setting_json.site_mobile') )}}" placeholder="">
                                @error('site_mobile')
                                <div class="alert-danger-soft">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-3">
                                <label for="crud-form-1" class="form-label">لوگو ۱</label>
                                <input name="site_logo" type="file" class="form-control w-full {{$errors->has('site_logo') ?'is-danger' :''}}" placeholder="">
                                @if( $view_model->getModelDataJson('main_setting_json.site_logo') )
                                    <img src="{{ url($view_model->getModelDataJson('main_setting_json.site_logo')) }}" style="width: 100px">
                                @endif
                                @error('site_logo')
                                    <div class="alert-danger-soft">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-3">
                                <label for="footer_text" class="form-label">متن فوتر</label>
                                <textarea name="footer_text" id="footer_text" type="text" class="form-control w-full {{$errors->has('site_title') ? 'is-danger' :''}}">
                                    {{old( 'footer_text' , $view_model->getModelDataJson('main_setting_json.footer_text') )}}
                                </textarea>
                                @error('footer_text')
                                <div class="alert-danger-soft">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>

                </div>
                <button class=" mr-2 btn btn-primary shadow-md flex items-center" aria-expanded="false" type="submit"> ذخیره </button>
                <!-- END: Post Content -->
            </div>
        </form>
    </div>
@endsection
