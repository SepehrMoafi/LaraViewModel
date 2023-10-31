@extends('core::theme_admin.layouts.app')

@section('content')
    <div class="content">
        <form @if(! $view_model->getModelData('id') ) action="{{ route('admin.shop.payments.store') }}" method="POST"
              @else action="{{ route('admin.shop.payments.update' , $view_model->getModelData('id') ) }}"
              method="POST" @endif  enctype="multipart/form-data">
            @csrf
            @if( $view_model->getModelData('id') ) @method('PUT') @endif

            <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                <h2 class="text-lg font-medium ml-auto">
                    کاتالوگ محصول
                </h2>

                <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                    <button class=" mr-2 btn btn-primary shadow-md flex items-center" aria-expanded="false" type="submit"> ذخیره </button>
                </div>
            </div>

            <!-- BEGIN: Invoice -->
            <div class="intro-y box overflow-hidden mt-5">

                <div class="px-5 sm:px-16 py-10 sm:py-20">
                    <p class="text-lg font-medium text-theme-17 dark:text-gray-300 mt-2">  </p>
                    <div class="overflow-x-auto">
                        <img style="max-width: 100%" src="{{ url( $view_model->getModelDataJson('paramsJson.bank_receipt_photo') ) }}">
                    </div>
                </div>

                <div class="px-5 sm:px-20 pb-10 sm:pb-20 flex flex-col-reverse sm:flex-row">
                    <div class="text-center sm:text-right mt-10 sm:mt-0">
                        <div class="text-base text-gray-600">وضعیت کنونی سفارش : {!!  $view_model->getModelData('status_text_badage') !!}</div>
                    </div>
                    <div class="text-center sm:text-right sm:mr-auto">

                        <label>مبلغ</label>
                        <input class="form-control mb-5" type="number" name="amount" value="{{ $view_model->getModelData('amount') }}">
                        <br>

                        <label for="">وضعیت جدید</label>
                        <select class="form-control mb-3" name="status" >
                            <option value="0" @if($view_model->getModelData('status') == 0) selected @endif>در انتظار تایید</option>
                            <option value="1" @if($view_model->getModelData('status') == 1) selected @endif>تایید</option>
                            <option value="2" @if($view_model->getModelData('status') == 2) selected @endif>رد</option>
                        </select>

                        <button class="btn btn-success mt-3">ثبت</button>
                    </div>
                </div>

            </div>
            <!-- END: Invoice -->

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

