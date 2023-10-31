@extends('core::theme_admin.layouts.app')

@section('content')
    <div class="content">
        <form @if(! $view_model->getModelData('id') ) action="{{ route('admin.user.users.store') }}" method="POST"
              @else action="{{ route('admin.user.users-company.update' , $view_model->getModelData('id') ) }}"
              method="POST" @endif  enctype="multipart/form-data">
            @csrf
            @if( $view_model->getModelData('id') ) @method('PUT') @endif

            <div class="intro-y flex items-center mt-8">
                <h2 class="text-lg font-medium ml-auto">
                    درخواست حقوقی کردن حساب کاربری
                </h2>
            </div>

            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: Profile Menu -->

                <!-- END: Profile Menu -->
                <div class="col-span-12 lg:col-span-12 xxl:col-span-12">
                    <!-- BEGIN: Display Information -->
                    <div class="intro-y box lg:mt-5">
                        <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                            <h2 class="font-medium text-base ml-auto">
                                نمایش اطلاعات
                            </h2>
                        </div>
                        <div class="p-5">
                            <div class="flex flex-col-reverse xl:flex-row flex-col">
                                <div class="flex-1 mt-6 xl:mt-0">
                                    <div class="grid grid-cols-12 gap-x-5">
                                        <div class="col-span-12 xxl:col-span-6">
                                            <div>
                                                <label class="form-label">نمایش نام</label>
                                                <p>{{ $view_model->getModelData('name') }}</p>
                                            </div>
                                        </div>
                                        <div class="col-span-12 xxl:col-span-6">
                                            <div class="mt-3">
                                                <label for="update-profile-form-4" class="form-label">شماره تماس</label>
                                                <p>{{ $view_model->getModelData('mobile') }}</p>
                                            </div>
                                        </div>
                                        <div class="col-span-12">

                                            <div class="col-span-12 mt-3">
                                                <label for="update-profile-form-6" class="form-label">ایمیل</label>
                                                <p>{{$view_model->getModelData('email')}}</p>
                                            </div>

                                            <div class="mt-3">
                                                <label for="update-profile-form-5" class="form-label">نوع کاربری</label>
                                                <select class="form-control" name="type">
                                                    <option @if(1 == $view_model->getModelData('type') ) selected @endif  value="1">حقیقی</option>
                                                    <option @if(2 == $view_model->getModelData('type') ) selected @endif  value="2">حقوقی</option>
                                                    <option @if(3 == $view_model->getModelData('type') ) selected @endif  value="3">حقوقی با جواز</option>
                                                </select>
                                            </div>

                                            <div class="mt-3">
                                                <label for="update-profile-form-5" class="form-label">وضعیت تایید نوع کاربری</label>
                                                <select class="form-control" name="company_confirm_status">
                                                    <option @if(0 == $view_model->getModelData('company_confirm_status') ) selected @endif  value="0">درخواستی ثبت نشده است</option>
                                                    <option @if(1 == $view_model->getModelData('company_confirm_status') ) selected @endif  value="1">تایید</option>
                                                    <option @if(2 == $view_model->getModelData('company_confirm_status') ) selected @endif  value="2">در انتظار برسی</option>
                                                    <option @if(3 == $view_model->getModelData('company_confirm_status') ) selected @endif  value="3">رد درخواست</option>
                                                </select>
                                            </div>

                                            <div class="mt-3">
                                                <label for="update-profile-form-5" class="form-label">اسم شرکت</label>
                                                <input type="text" name="params[company_name]" class="form-control {{$errors->has('params.company_name') ? 'is-danger' :''}}" value="{{old( 'params.company_name' , $view_model->getModelDataJson('paramsJson.company_name') )}}">
                                                @error('params.company_name')
                                                    <div class="alert-danger-soft">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mt-3 xxl:mt-0">
                                                <label for="update-profile-form-3" class="form-label">کد اقتصادی</label>
                                                <input type="text" name="params[economic_code]" class="form-control {{$errors->has('params.economic_code') ? 'is-danger' :''}}" value="{{old( 'params.economic_code' , $view_model->getModelDataJson('paramsJson.economic_code') )}}">
                                                @error('params.economic_code')
                                                <div class="alert-danger-soft">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-span-12 mt-3">
                                            <label for="update-profile-form-6" class="form-label">شناسه ملی</label>
                                            <input type="text" name="params[national_id]" class="form-control {{$errors->has('params.national_id') ? 'is-danger' :''}}" value="{{old( 'params.national_id' , $view_model->getModelDataJson('paramsJson.national_id') )}}">
                                            @error('params.national_id')
                                            <div class="alert-danger-soft">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-span-12 mt-5">
                                            @if($view_model->getModelDataJson('paramsJson.company_doc_1') )
                                                <img src="{{ $view_model->getModelDataJson('paramsJson.company_doc_1') }}" style="width: 50%" alt="">
                                            @endif
                                            @if($view_model->getModelDataJson('paramsJson.company_doc_2') )
                                                <img src="{{ $view_model->getModelDataJson('paramsJson.company_doc_2') }}" style="width: 50%" alt="">
                                            @endif
                                        </div>

                                    </div>
                                    <button type="submit" class="btn btn-primary w-20 mt-3">ذخیره</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- END: Display Information -->
                </div>
            </div>

        </form>
    </div>


@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/theme_admin/dist/jdate/persian-datepicker.min.css') }}"/>
@endsection


@section('scripts')
{{--    <script src="{{ asset('assets/theme_admin/dist/ckeditor5/ckeditor.js') }}"></script>--}}

    <script src="{{ asset('assets/theme_admin/dist/jdate/persian-date.min.js') }}"></script>
    <script src="{{ asset('assets/theme_admin/dist/jdate/persian-datepicker.min.js') }}"></script>

    <script>
        $(document).ready(function() {


            $(".example1").pDatepicker(
                {
                    initialValueType: 'gregorian',
                    format: 'YYYY-MM-DD',
                    calendar:{
                        persian: {
                            locale: 'en'
                        }
                    }

                }
            );

            $('.js-select-tag').select2({
                'tags': true,
            });

            $('.js-select-2').select2();
        });
    </script>

@endsection
