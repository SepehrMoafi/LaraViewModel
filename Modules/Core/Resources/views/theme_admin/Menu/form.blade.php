@extends('core::theme_admin.layouts.app')

@section('content')
    <div class="content">
        <form @if(! $view_model->getModelData('id') ) action="{{ route('admin.core.menus.store') }}" method="POST"
              @else action="{{ route('admin.core.menus.update' , $view_model->getModelData('id') ) }}"
              method="POST" @endif  enctype="multipart/form-data">
            @csrf
            @if( $view_model->getModelData('id') ) @method('PUT') @endif

            <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                <h2 class="text-lg font-medium ml-auto">
                    منو
                </h2>

                <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                    <button class=" mr-2 btn btn-primary shadow-md flex items-center" aria-expanded="false" type="submit"> ذخیره </button>
                </div>
            </div>

            <div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
                <!-- BEGIN: Post Content -->
                <div class="intro-y col-span-12 lg:col-span-12">

                    <label for="crud-form-1" class="form-label">عنوان</label>
                    <input name="title" id="crud-form-3" type="text" class="form-control w-full {{$errors->has('title') ? 'is-danger' :''}}" value="{{old( 'title' , $view_model->getModelData('title') )}}" placeholder="">
                    @error('title')
                        <div class="alert-danger-soft">{{ $message }}</div>
                    @enderror

                    <label for="crud-form-1" class="form-label">لینک</label>
                    <input name="link" id="crud-form-3" type="text" class="form-control w-full {{$errors->has('link') ? 'is-danger' :''}}" value="{{old( 'link' , $view_model->getModelData('link') )}}" placeholder="">
                    @error('link')
                    <div class="alert-danger-soft">{{ $message }}</div>
                    @enderror

                    <label for="crud-form-1" class="form-label">مرتب سازی</label>
                    <input name="sort" id="crud-form-3" type="number" class="form-control w-full {{$errors->has('sort') ? 'is-danger' :''}}" value="{{old( 'sort' , $view_model->getModelData('sort') )}}" placeholder="">
                    @error('sort')
                        <div class="alert-danger-soft">{{ $message }}</div>
                    @enderror

                    <div class="mt-3">

                        <label for="post-form-3" class="form-label">منو والد</label>
                        <select name="parent_id" class="form-control  js-select-2 {{$errors->has('parent_id') ? 'is-danger' :''}}">
                            <option value="0">انتخاب کنید </option>
                            @foreach($view_model->getMenuList() as $category)
                                <option @if( @ $view_model->getModelData('parent_id') == $category->id ) selected @endif value="{{$category->id}}">{{ $category->title }}</option>
                            @endforeach
                        </select>

                        @error('parent_id')
                        <div class="alert-danger-soft">{{ $message }}</div>
                        @enderror

                    </div>


                </div>
                <!-- END: Post Content -->

            </div>
            <div style="margin-top: 30px" class="w-full sm:w-auto flex mt-4 sm:mt-0 mt-3">
                <button class=" mr-2 btn btn-primary shadow-md flex items-center" aria-expanded="false" type="submit"> ذخیره </button>
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
