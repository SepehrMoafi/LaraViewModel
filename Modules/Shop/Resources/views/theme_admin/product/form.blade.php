@extends('core::theme_admin.layouts.app')

@section('content')
    <div class="content">
        <form @if(! $view_model->getModelData('id') ) action="{{ route('admin.shop.product.store') }}" method="POST"
              @else action="{{ route('admin.shop.product.update' , $view_model->getModelData('id') ) }}"
              method="POST" @endif  enctype="multipart/form-data">
            @csrf
            @if( $view_model->getModelData('id') ) @method('PUT') @endif

            <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                <h2 class="text-lg font-medium ml-auto">
                      محصول
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
                            <label class="form-label">انتخاب کاتالوگ</label>
                            <select name="product_catalog_id" data-search="true" class="form-control js-select-2 {{$errors->has('product_catalog_id') ? 'is-danger' :''}}">
                                @foreach( $view_model->getCatalogList() as $pp)
                                    <option @if( $view_model->getModelData('product_catalog_id') == $pp->id ) selected @endif value="{{ $pp->id }}"> {{ $pp->title }} </option>
                                @endforeach
                            </select>
                            @error('product_catalog_id')
                            <div class="alert-danger-soft">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mt-3">
                            <div class="sm:grid grid-cols-3 gap-2">

                                <div class="input-group mt-2 sm:mt-0">
                                    <div id="input-group-4" class="input-group-text">قیمت </div>
                                    <input type="text" class="form-control {{$errors->has('price') ? 'is-danger' :''}}"  name="price" value="{{old( 'price' , $view_model->getModelData('price') )}}" aria-describedby="input-group-4">
                                </div>
                                @error('price')
                                <div class="alert-danger-soft">{{ $message }}</div>
                                @enderror


                                <div class="input-group mt-2 sm:mt-0">
                                    <div id="input-group-4" class="input-group-text">تخفیف </div>
                                    <input type="text" class="form-control {{$errors->has('discount') ? 'is-danger' :''}}"  name="discount" value="{{old( 'discount' , $view_model->getModelData('discount') )}}" aria-describedby="input-group-4">
                                </div>
                                @error('discount')
                                <div class="alert-danger-soft">{{ $message }}</div>
                                @enderror



                                <div class="input-group mt-2 sm:mt-0">
                                    <div id="input-group-4" class="input-group-text">تعداد </div>
                                    <input type="text" class="form-control {{$errors->has('qty') ? 'is-danger' :''}}"  name="qty" value="{{old( 'qty' , $view_model->getModelData('qty') )}}" aria-describedby="input-group-4">
                                </div>
                                @error('qty')
                                <div class="alert-danger-soft">{{ $message }}</div>
                                @enderror



                                <div class="input-group mt-2 sm:mt-0">
                                    <div id="input-group-4" class="input-group-text">رنگ </div>
                                    <input style="height: 37px;" type="color" class="form-control {{$errors->has('color') ? 'is-danger' :''}} "  name="color" value="{{ old( 'color' , $view_model->getModelData('color') ) }}" aria-describedby="input-group-4">
                                </div>
                                @error('color')
                                <div class="alert-danger-soft">{{ $message }}</div>
                                @enderror

                                <div class="input-group mt-2 sm:mt-0">
                                    <div id="input-group-4" class="input-group-text">گارانتی </div>
                                    <input type="text" class="form-control {{$errors->has('warranty') ? 'is-danger' :''}} "  name="warranty" value="{{old( 'warranty' , $view_model->getModelData('warranty') )}}" aria-describedby="input-group-4">
                                </div>
                                @error('warranty')
                                <div class="alert-danger-soft">{{ $message }}</div>
                                @enderror

                                <div class="input-group mt-2 sm:mt-0">
                                    <div id="input-group-4" class="input-group-text">وزن </div>
                                    <input type="text" class="form-control {{$errors->has('wight') ? 'is-danger' :''}} "  name="wight" value="{{old( 'wight' , $view_model->getModelData('wight') )}}" aria-describedby="input-group-4">
                                </div>
                                @error('wight')
                                <div class="alert-danger-soft">{{ $message }}</div>
                                @enderror


                                <div class="input-group mt-2 sm:mt-0">
{{--                                    <button class="btn btn-info">دریافت کد کالا</button>--}}
                                </div>

                                <div class="input-group mt-2 sm:mt-0">
{{--                                    <span>--}}
{{--                                        کد : 456455--}}
{{--                                    </span>--}}
                                </div>

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
