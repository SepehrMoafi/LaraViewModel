@extends('core::theme_admin.layouts.app')

@section('content')
    <div class="content">
        <form @if(! $view_model->getModelData('id') ) action="{{ route('admin.shop.delivery.store') }}" method="POST"
              @else action="{{ route('admin.shop.delivery.update' , $view_model->getModelData('id') ) }}"
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
                            @php
                                $selectedCity = $view_model->getModelData('cities_id') ? json_decode($view_model->getModelData('cities_id') , true) : [];
                            @endphp
                            <label class="form-label">انتخاب شهر</label>
                            <select name="cities[]" data-search="true" multiple class="form-control js-select-2 {{$errors->has('cities') ? 'is-danger' :''}}">
                                @foreach( $view_model->getCities() as $pp)
                                    @php
                                         $selected = in_array($pp->id , $selectedCity ) ;
                                    @endphp
                                    <option @if( $selected ) selected @endif value="{{ $pp->id }}"> {{ $pp->name }} </option>
                                @endforeach
                            </select>

                            @error('cities')
                                <div class="alert-danger-soft">{{ $message }}</div>
                            @enderror

                        </div>


                        <div class="mt-3">
                            <div class="sm:grid grid-cols-3 gap-2">

                                <div class="input-group mt-2 sm:mt-0">
                                    <div id="input-group-4" class="input-group-text"> قیمت </div>
                                    <input type="number" class="form-control {{$errors->has('price') ? 'is-danger' :''}}"  name="price" value="{{old( 'price' , $view_model->getModelData('price') )}}" aria-describedby="input-group-4">
                                </div>
                                @error('price')
                                <div class="alert-danger-soft">{{ $message }}</div>
                                @enderror


                                <div class="input-group mt-2 sm:mt-0">
                                    <div id="input-group-4" class="input-group-text">عنوان </div>
                                    <input type="text" class="form-control {{$errors->has('title') ? 'is-danger' :''}}"  name="title" value="{{old( 'title' , $view_model->getModelData('title') )}}" aria-describedby="input-group-4">
                                </div>
                                @error('title')
                                <div class="alert-danger-soft">{{ $message }}</div>
                                @enderror

                                <div class="input-group mt-2 sm:mt-0">

                                    <div id="input-group-4" class="input-group-text">وضعیت </div>
                                    <select name="status" >
                                        <option value="1" @if($view_model->getModelData('status') == 1) selected @endif>فعال</option>
                                        <option value="2" @if($view_model->getModelData('status') == 2) selected @endif>غیر فعال </option>
                                    </select>

                                </div>

                                @error('status')
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
