@extends('core::theme_admin.layouts.app')

@section('content')
    <style>
        p.color-danger.danger {
            color: red;
            margin-top: 7px;
        }
        p.color-success.success {
            color: #035100;
            margin-top: 7px;
        }
    </style>
    <div class="content">
        @if(session()->has('res_text'))
            <div style="
                margin-top: 50px;
                padding: 10px;
                border-radius: 10px;
                background: #eeeeee;
                direction: ltr;
            ">
                {!! session()->get('res_text') !!}
            </div>
        @endif
        <form @if(! $view_model->getModelData('id') ) action="{{ route('admin.shop.product.update-taraz-with-text') }}" method="POST"
              @else action="{{ route('admin.shop.product.update-taraz-with-text' , $view_model->getModelData('id') ) }}"
              method="POST" @endif  enctype="multipart/form-data">
            @csrf
            @if( $view_model->getModelData('id') ) @method('PUT') @endif

            <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                <h2 class="text-lg font-medium ml-auto">

                </h2>

                <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                    <button class=" mr-2 btn btn-primary shadow-md flex items-center" aria-expanded="false" type="submit"> ذخیره </button>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="intro-y col-span-12 lg:col-span-12">
                    <!-- BEGIN: Form Layout -->
                    <div class="intro-y box p-5">


                        <div class="mt-3">
                            <div class="sm:grid grid-cols-1 gap-2">

                                <div class="input-group mt-2 sm:mt-0">
                                    <div id="input-group-4" class="input-group-text">کد ها </div>
                                    <textarea name="codes" class="form-control  {{$errors->has('codes') ? 'is-danger' :''}}" rows="10">{{old( 'codes' )}}</textarea>
                                </div>
                                @error('codes')
                                <div class="alert-danger-soft">{{ $message }}</div>
                                @enderror

                            </div>

                        </div>


                        <div class="text-left mt-5">
                            <button type="submit" class="btn btn-primary w-24">ذخیره</button>
                        </div>

                    </div>
                    <!-- END: Form Layout -->
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
