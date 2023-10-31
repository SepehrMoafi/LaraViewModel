@extends('core::theme_admin.layouts.app')

@section('content')
    <div class="content">
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium ml-auto">
                کد تخفیف
            </h2>
        </div>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 lg:col-span-12">
                <!-- BEGIN: Form Layout -->
                <form action="{{route('admin.shop.copan.store')}}" method="post">
                    @csrf
                    <div class="intro-y box p-5">
                        <div>
                            <label for="crud-form-1" class="form-label">کد</label>
                            <input id="crud-form-1" type="text" name="code" class="form-control w-full {{$errors->has('code') ? 'is-danger' :''}}"
                                   placeholder="متن ورودی" value="{{ old('code') }}">
                            @error('code')
                            <span class="alert-danger-soft mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="crud-form-1" class="form-label">درصد</label>
                            <input id="crud-form-2" name="amount" type="text" class="form-control w-full {{$errors->has('amount') ? 'is-danger' :''}}"
                                   placeholder="متن ورودی" value="{{ old('amount') }}">
                            @error('amount')
                            <span class="alert-danger-soft mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="crud-form-1" class="form-label">تعداد مجاز استفاده</label>
                            <input id="crud-form-2" checked  name="allowed_number_of_uses" type="text"
                                   class="form-control w-full {{$errors->has('allowed_number_of_uses') ? 'is-danger' :''}}" placeholder="متن ورودی" value="{{ old('allowed_number_of_uses') }}">
                            @error('allowed_number_of_uses')
                            <span class="alert-danger-soft mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <br>

                        <div class="sm:mr-auto mt-3 sm:mt-0 relative text-gray-700 dark:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round"
                                 class="feather feather-calendar w-4 h-4 z-10 absolute my-auto inset-y-0 mr-3 right-0">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <input type="text" name="date" class="datepicker form-control sm:w-56 box pr-10 {{$errors->has('date') ? 'is-danger' :''}}">
                            @error('date')
                            <span class="alert-danger-soft mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-3 flex items-center">
                            <label>وضعیت فعال بودن</label>
                            <div class="mt-2 ml-8 mr-2">
                                <input type="hidden" name="status" value="0">
                                <input type="checkbox" value="1" name="status" class="{{$errors->has('status') ? 'is-danger' :''}} form-check-switch" {{ old('status') ? ' checked' : '' }} >
                                @error('status')
                                <span class="alert-danger-soft mt-2">{{ $message }}</span>
                                @enderror
                            </div>


                            <label> برای اولین خرید ؟ </label>
                            <div class="mt-2 ml-8 mr-2">
                                <input type="hidden" name="first_buy" value="0">
                                <input type="checkbox" value="1" name="first_buy" class="form-check-switch {{$errors->has('first_buy') ? 'is-danger' :''}}" {{ old('status') ? ' checked' : '' }}>
                                @error('first_buy')
                                <span class="alert-danger-soft mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="text-left mt-5">
                            <button type="button" class="btn btn-outline-secondary w-24 ml-1">لغو</button>
                            <button type="submit" class="btn btn-primary w-24">ذخیره</button>
                        </div>


                    </div>
                </form>
                <!-- END: Form Layout -->
            </div>
        </div>
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
        $(document).ready(function () {


            $(".example1").pDatepicker(
                {
                    initialValueType: 'gregorian',
                    format: 'YYYY-MM-DD',
                    calendar: {
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
