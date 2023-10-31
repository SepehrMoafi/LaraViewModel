@extends('core::theme_admin.layouts.app')

@section('content')
    <div class="content">
        <form @if(! $view_model->getModelData('id') ) action="{{ route('admin.blog.posts.store') }}" method="POST"
              @else action="{{ route('admin.blog.posts.update' , $view_model->getModelData('id') ) }}"
              method="POST" @endif  enctype="multipart/form-data">
            @csrf
            @if( $view_model->getModelData('id') ) @method('PUT') @endif

            <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                <h2 class="text-lg font-medium ml-auto">
                     پست
                </h2>

                <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                    <button class=" mr-2 btn btn-primary shadow-md flex items-center" aria-expanded="false" type="submit"> ذخیره </button>
                </div>
            </div>

            <div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
                <!-- BEGIN: Post Content -->
                <div class="intro-y col-span-12 lg:col-span-8">

                    <label for="crud-form-1" class="form-label">عنوان</label>
                    <input name="title" id="crud-form-3" type="text" class="form-control w-full {{$errors->has('title') ? 'is-danger' :''}}" value="{{old( 'title' , $view_model->getModelData('title') )}}" placeholder="">
                    @error('title')
                        <div class="alert-danger-soft">{{ $message }}</div>
                    @enderror


                    <div class="post intro-y overflow-hidden box mt-5">

                        <div class="post__content tab-content">
                            <div id="content" class="tab-pane p-5 active" role="tabpanel" aria-labelledby="content-tab">
                                <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5">

                                    <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5"> <i data-feather="chevron-down" class="w-4 h-4 ml-2"></i> محتوای متن </div>
                                    <div class="mt-5">
                                        @error('body')
                                            <div class="alert-danger-soft">{{ $message }}</div>
                                        @enderror
                                        <div class="editor-container">
                                            <textarea name="body" id="editor" class="html-editor">
                                                {!! old( 'body' , $view_model->getModelData('body') ) !!}
                                            </textarea>
                                        </div>

                                    </div>

                                    <div class="mt-5">
                                        <label for="post-form-7" class="form-label"> کپشن </label>
                                        <input id="post-form-7"
                                               name="description"
                                               class="form-control {{$errors->has('description') ? 'is-danger' :''}}"
                                               value="{{old( 'description' , $view_model->getModelData('description') )}}"
                                               type="text">
                                        @error('description')
                                        <div class="alert-danger-soft">{{ $message }}</div>
                                        @enderror

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
                                <div class="post__content tab-content" id="tab-meta">
                                    <div id="content" class="tab-pane p-5 active">
                                        <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5">
                                            <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5"> <i data-feather="chevron-down" class="w-4 h-4 ml-2"></i>اسلاگ</div>
                                            <div class="mt-5">
                                                <textarea name="slug" class="form-control  {{$errors->has('slug') ? 'is-danger' :''}}">{{old( 'slug' , $view_model->getModelData('slug') )}}</textarea>
                                                @error('slug')
                                                <div class="alert-danger-soft">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="post__content tab-content" id="tab-meta">
                                    <div id="content" class="tab-pane p-5 active">
                                        <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5">
                                            <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5"> <i data-feather="chevron-down" class="w-4 h-4 ml-2"></i> متا تگ</div>
                                            <div class="mt-5">
                                                <textarea name="params[meta_tag]"  class="form-control  {{$errors->has('params.meta_tag') ? 'is-danger' :''}}">{{old( 'params.meta_tag' , $view_model->getModelDataJson('paramsJson.meta_tag') )}}</textarea>
                                                @error('params.meta_tag')
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

                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Post Content -->
                <!-- BEGIN: Post Info -->
                <div class="col-span-12 lg:col-span-4">
                    <div class="intro-y box p-5">

                        <div>
                            <label class="form-label">نویسنده:</label>
                            <select name="author_id" class="form-control  {{$errors->has('author_id') ? 'is-danger' :''}}">
                                @foreach($view_model->getAuthorsList() as $user)
                                    <option value="{{$user->id}}"
                                            @if( $view_model->getModelData('author_id') )
                                                @if($user->id == $view_model->getModelData('author_id') ) selected @endif
                                            @else
                                                @if( @ auth()->user()->id == $user->id ) selected @endif
                                            @endif
                                    >{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('author_id')
                                <div class="alert-danger-soft">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <label for="post-form-2" class="form-label">تاریخ پست</label>
                            <input name="post_date" class="form-control example1 {{$errors->has('post_date') ? 'is-danger' :''}}"
                                   value="{{old( 'post_date' , $view_model->getModelData('post_date') )}}"
                                   id="post-form-2" data-single-mode="true">
                            @error('post_date')
                                <div class="alert-danger-soft">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <label for="post-form-3" class="form-label">دسته‌بندی</label>
                            <select name="categories[]" multiple class="form-control  js-select-2 {{$errors->has('categories') ? 'is-danger' :''}}">

                                @foreach($view_model->getCategoriesList() as $category)

                                    <option @if( $view_model->getModelData('categories')->where('category_id' , $category->id )->count() > 0 ) selected @endif value="{{$category->id}}">{{ $category->title }}</option>
                                @endforeach
                            </select>

                            @error('categories')
                                <div class="alert-danger-soft">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <label for="" class="form-label">برچسب ها</label>
                            <select name="tags[]" multiple class="form-control js-select-tag">
                                @foreach( $view_model->getTagsList() as $tag)
                                    <option @if( $view_model->getModelData('tags')->where('tag_id' , $tag->id )->count() > 0 ) selected @endif value="{{ $tag->title }}"> {{ $tag->title }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-3">
                            <label class="form-label">مطالب مرتبط</label>
                            <select name="rel_posts[]" data-search="true" class="form-control js-select-2" multiple>
                                @foreach( $view_model->getPostList() as $post)
                                    <option @if( $view_model->getModelData('postsRelated')->where('post_id' , $post->id )->count() > 0 ) selected @endif value="{{ $post->id }}"> {{ $post->title }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-3">
                            <label for="crud-form-1" class="form-label">تصویر</label>
                            <input name="image" type="file" class="form-control w-full {{ $errors->has('image') ?'is-danger' :'' }}" placeholder="">
                            @if( $view_model->getModelData('image') )
                                <img src="{{url($view_model->getModelData('image'))  }}" style="width: 100%">
                            @endif
                            @error('image')
                                <div class="alert-danger-soft">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="form-check flex-col items-start mt-3">
                            <label for="post-form-5"  class="form-check-label ml-0 mb-2">منتشرشده</label>
                            <input id="post-form-5" @if( $view_model->getModelData('status') == 1 ) checked @endif class="form-check-switch"  name="publish" type="checkbox">
                        </div>

                        <div class="form-check flex-col items-start mt-3">
                            <label for="post-form-6" class="form-check-label ml-0 mb-2">نمایش نام نویسنده</label>
                            <input id="post-form-6" class="form-check-switch"  @if( $view_model->getModelDataJson('paramsJson.show_author') == 'on' ) checked @endif name="params[show_author]" type="checkbox">
                        </div>

                    </div>
                </div>
                <!-- END: Post Info -->
            </div>



        </form>
    </div>


@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/theme_admin/dist/jdate/persian-datepicker.min.css') }}"/>
@endsection


@section('scripts')

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
