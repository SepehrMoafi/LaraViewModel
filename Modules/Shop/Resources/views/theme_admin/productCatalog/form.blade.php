@extends('core::theme_admin.layouts.app')

@section('content')
    <div class="content">
        <form @if(! $view_model->getModelData('id') ) action="{{ route('admin.shop.product-catalog.store') }}" method="POST"
              @else action="{{ route('admin.shop.product-catalog.update' , $view_model->getModelData('id') ) }}"
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

            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="intro-y col-span-12 lg:col-span-12">
                    <!-- BEGIN: Form Layout -->
                    <div class="intro-y box p-5">

                        <div>
                            <label for="crud-form-1" class="form-label">نام محصول</label>
                            <input name="title" id="crud-form-3" type="text" class="form-control w-full {{$errors->has('title') ? 'is-danger' :''}}"
                                   value="{{old( 'title' , $view_model->getModelData('title') )}}" placeholder="">
                            @error('title')
                                <div class="alert-danger-soft">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <label for="crud-form-1" class="form-label">عنوان لاتین</label>
                            <input name="en_title" id="crud-form-3" type="text" class="form-control w-full {{$errors->has('en_title') ? 'is-danger' :''}}"
                                   value="{{old( 'en_title' , $view_model->getModelData('en_title') )}}" placeholder="">
                            @error('en_title')
                                <div class="alert-danger-soft">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <label for="crud-form-1" class="form-label">عنوان دوم</label>
                            <input name="2nd_title" id="crud-form-3" type="text" class="form-control w-full {{$errors->has('2nd_title') ? 'is-danger' :''}}"
                                   value="{{old( '2nd_title' , $view_model->getModelData('2nd_title') )}}" placeholder="">
                            @error('2nd_title')
                                <div class="alert-danger-soft">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <label for="crud-form-1" class="form-label">تصویر</label>
                            <input name="image" type="file" class="form-control w-full {{ $errors->has('image') ?'is-danger' :'' }}" placeholder="">
                            @if( $view_model->getModelData('image') )
                                <img src="{{url($view_model->getModelData('image'))  }}" style="width: 50%">
                            @endif
                            @error('image')
                            <div class="alert-danger-soft">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">

                            <label for="crud-form-2" class="form-label"> دسته بندی </label>
                            <select name="categories[]" multiple class="form-control  js-select-2 {{$errors->has('categories') ? 'is-danger' :''}}">

                                @foreach($view_model->getCategoriesList() as $category)
                                    <option @if($view_model->getModelData('categories') &&  $view_model->getModelData('categories')->where('category_id' , $category->id )->count() > 0 ) selected @endif value="{{$category->id}}">{{ $category->title }}</option>
                                @endforeach

                            </select>
                            @error('categories')
                                <div class="alert-danger-soft">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="mt-3">

                            <label for="crud-form-2" class="form-label"> برند </label>
                            <select name="brand_id" class="form-control  js-select-2 {{$errors->has('brand_id') ? 'is-danger' :''}}">
                                @foreach($view_model->getBrandList() as $brand)
                                    <option @if($view_model->getModelData('brand_id') ==  $brand->id  ) selected @endif value="{{$brand->id}}">{{ $brand->title }}</option>
                                @endforeach
                            </select>
                            @error('brand_id')
                            <div class="alert-danger-soft">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="mt-3">
                            <label class="form-label">نوع محصول</label>
                            <select name="type" data-search="true" class="form-control " >
                                <option @if( $view_model->getModelData('type') == 1 ) selected @endif value="1"> موبایل </option>
                                <option @if( $view_model->getModelData('type') == 2 ) selected @endif value="2"> لوازم جانبی </option>
                            </select>
                        </div>
                        <div class="mt-3 ">
                            <label class="form-label">محصولات مرتبط</label>
                            <select name="rel_products[]" data-search="true" class="form-control js-select-2" multiple>

                                @foreach( $view_model->getProductList() as $post)
                                    <option @if($view_model->getModelData('relProduct') &&  $view_model->getModelData('relProduct')->where('product_catalog_id' , $post->id )->count() > 0 ) selected @endif value="{{ $post->id }}"> {{ $post->title }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-3">
                            <label class="form-label">لوازم جانبی پیشنهادی برای این محصول</label>
                            <select name="rel_product_accessory[]" data-search="true" class="form-control js-select-2" multiple>
                                @foreach( $view_model->getProductAccessoryList() as $post)
                                    <option @if($view_model->getModelData('relProductAccessory') && $view_model->getModelData('relProductAccessory')->where('product_catalog_id' , $post->id )->count() > 0 ) selected @endif value="{{ $post->id }}"> {{ $post->title }} </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="mt-3 flex items-center">
                            <label>وضعیت فعال بودن</label>
                            <div class="mt-2 ml-8 mr-2">
                                <input name="is_active" @if( $view_model->getModelData('is_active') == 1 ) checked @endif  type="checkbox" class="form-check-switch">
                            </div>
                            <label> محصول ویژه </label>
                            <div class="mt-2 ml-8 mr-2">
                                <input name="is_special" @if( $view_model->getModelData('is_special') == 1 ) checked @endif  type="checkbox" class="form-check-switch">
                            </div>
                            <label> به زودی </label>
                            <div class="mt-2 ml-8 mr-2">
                                <input name="is_coming_soon" @if( $view_model->getModelData('is_coming_soon') == 1 ) checked @endif type="checkbox" class="form-check-switch">
                            </div>

                            <label> اتمام فروش </label>
                            <div class="mt-2 ml-8 mr-2">
                                <input  name="out_of_sell" @if( $view_model->getModelData('out_of_sell') == 1 ) checked @endif  type="checkbox" class="form-check-switch">
                            </div>

{{--                            <label> گردونه شانس </label>--}}
{{--                            <div class="mt-2 ml-8 mr-2">--}}
{{--                                <input  name="out_of_sell" @if( $view_model->getModelData('out_of_sell') == 1 ) checked @endif   type="checkbox" class="form-check-switch">--}}
{{--                            </div>--}}

                        </div>
                        <div class="mt-3">
                            <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5"> <i data-feather="chevron-down" class="w-4 h-4 ml-2"></i> معرفی </div>
                            <div class="mt-5">
                                @error('description')
                                <div class="alert-danger-soft">{{ $message }}</div>
                                @enderror
                                <textarea name="description" id="editor1" class="html-editor">
                                            {!! old( 'description' , $view_model->getModelData('description') ) !!}
                                </textarea>
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5"> <i data-feather="chevron-down" class="w-4 h-4 ml-2"></i> ویژگی های محصول </div>
                            <div class="mt-5">
                                @error('product_attribute')
                                <div class="alert-danger-soft">{{ $message }}</div>
                                @enderror
                                <textarea name="product_attribute" id="editor2" class="html-editor">
                                            {!! old( 'product_attribute' , $view_model->getModelData('product_attribute') ) !!}
                                </textarea>
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5"> <i data-feather="chevron-down" class="w-4 h-4 ml-2"></i> ویژگی های محصول کنار عکس</div>
                            <div class="mt-5">

                                @error('params.product_attribute_image')
                                <div class="alert-danger-soft">{{ $message }}</div>
                                @enderror

                                <textarea name="params[product_attribute_image]" id="editor3" class="html-editor">
                                           {!! old( 'params.product_attribute_image' , $view_model->getModelDataJson('paramsJson.product_attribute_image') ) !!}
                                </textarea>

                            </div>
                        </div>

                        </div>

                        <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5 mt-5">
                            <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5"> <i data-feather="chevron-down" class="w-4 h-4 ml-2"></i>  تصاویر </div>
                            <div class="mt-5">

                                <div class="mt-3">
                                    <label class="form-label">آپلود تصویر</label>
                                    <div class="border-2 border-dashed dark:border-dark-5 rounded-md pt-4">
                                        <div class="flex flex-wrap px-4">
                                            @if( $view_model->getModelData('images') )
                                                @foreach($view_model->getModelData('images') as $image )

                                                    <div class="w-24 h-24 relative image-fit mb-5 ml-5 cursor-pointer zoom-in">
                                                        <img class="rounded-md" alt="Icewall Tailwind HTML Admin Template" src="{{$image->src}}">
                                                        {{-- TODO remove with ajax--}}
                                                        <a href="{{ route('admin.core.dropzone.remove' , $image->id ) }}" title="حذف تصویر؟" class="tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-theme-24 left-0 top-0 -ml-2 -mt-2"> <i data-feather="x" class="w-4 h-4"></i> </a>
                                                    </div>

                                                @endforeach
                                            @endif


                                        </div>
                                        <div class="px-4 pb-4 flex items-center cursor-pointer relative dark:text-gray-500">
                                            <i data-feather="image" class="w-4 h-4 ml-2"></i> <span class="text-theme-1 dark:text-gray-300 ml-1">فایل را آپلود کنید</span> یا بکشید و بیاندازید
                                            <input type="file" name="images[]" multiple class="w-full h-full top-0 left-0 absolute opacity-0">
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="post__content tab-content" id="tab-meta">
                            <div id="content" class="tab-pane p-5 active">
                                <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5">
                                    <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5"> <i data-feather="chevron-down" class="w-4 h-4 ml-2"></i> توضیحات متا </div>
                                    <div class="mt-5">
                                        <textarea name="params[meta_description]"  class="form-control  {{$errors->has('params.meta_description') ? 'is-danger' :''}}">{{old( 'params.meta_description' , $view_model->getModelDataJson('paramsJson.meta_description') )}}</textarea>
                                        @error('params.meta_description')
                                        <div class="alert-danger-soft">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="post__content tab-content" id="tab-keyword">
                            <div id="content" class="tab-pane p-5 active">
                                <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5">
                                    <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5"> <i data-feather="chevron-down" class="w-4 h-4 ml-2"></i> کلمه کلیدی </div>
                                    <div class="mt-5">
                                                <textarea name="params[meta_key]"
                                                          class="form-control {{$errors->has('params.meta_key') ? 'is-danger' :''}}">{{old( 'params.meta_key' , $view_model->getModelDataJson('paramsJson.meta_key') )}}</textarea>
                                        @error('params.meta_key')
                                        <div class="alert-danger-soft">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="post__content tab-content" id="tab-keyword">
                            <div id="content" class="tab-pane p-5 active">
                                <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5">
                                    <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5"> <i data-feather="chevron-down" class="w-4 h-4 ml-2"></i> کد ویدیو </div>
                                    <div class="mt-5">
                                                    <textarea name="params[embed_video]"
                                                              class="form-control {{$errors->has('params.embed_video') ? 'is-danger' :''}}">{{old( 'params.embed_video' , $view_model->getModelDataJson('paramsJson.embed_video') )}}</textarea>
                                        @error('params.embed_video')
                                        <div class="alert-danger-soft">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="post__content tab-content" id="tab-keyword">
                            <div id="content" class="tab-pane p-5 active">
                                <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5">
                                    <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5"> <i data-feather="chevron-down" class="w-4 h-4 ml-2"></i> ویژگی ها </div>
                                    <div class="mt-5">
                                        @foreach($view_model->getAttributeList() as $attr )

                                            <div class="grid grid-cols-2 gap-4 mt-3">

                                                <div>
                                                    <div class="mt-2 ml-8 mr-2">
                                                       <p> {{ $attr->title }} </p>
                                                    </div>
                                                </div>

                                                <div>
                                                    <div class="mt-2 ml-8 mr-2">
                                                        <select name="attrs[{{$attr->id}}][0][value]"  class="form-control js-select-tag">
                                                            <option value="0">...</option>
                                                            @foreach( $attr->values as $atv)
                                                                <option @if( $view_model->getModelData('attributes')->where('attribute_id' , $atv->attribute_id )->where('value_id' ,$atv->id )->count() > 0 ) selected @endif value="{{ $atv->value }}"> {{ $atv->value }} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                        @endforeach
                                    </div>
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



    <script src="{{ asset('assets/theme_admin/dist/ckeditor/ckeditor.js') }}"></script>

    <script>

        $( document ).ready(function() {

            if ($('.html-editor').length) {
                $('.html-editor').each(function (index) {
                    var id = $(this).attr('id');
                    CKEDITOR.replace(id, null);
                });
            }
        });

    </script>

@endsection
