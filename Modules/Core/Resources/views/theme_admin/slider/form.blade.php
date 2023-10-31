@extends('core::theme_admin.layouts.app')

@section('content')
    <div class="content">
        <form @if(! $view_model->getModelData('id') ) action="{{ route('admin.core.sliders.store') }}" method="POST"
              @else action="{{ route('admin.core.sliders.update' , $view_model->getModelData('id') ) }}"
              method="POST" @endif  enctype="multipart/form-data">
            @csrf
            @if( $view_model->getModelData('id') ) @method('PUT') @endif

            <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                <h2 class="text-lg font-medium ml-auto">
                     اسلایدر / بنر
                </h2>

                <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                    <button class=" mr-2 btn btn-primary shadow-md flex items-center" aria-expanded="false" type="submit"> ذخیره </button>
                </div>
            </div>
            <div style="background: white;padding: 10px" class="pos intro-y grid grid-cols-12 gap-5 mt-5">
                <!-- BEGIN: Post Content -->
                <div  class="intro-y col-span-12 lg:col-span-12">

                    <div>
                        <div class="sm:grid grid-cols-2 gap-2">

                            <div class="mt-3">
                                <label for="crud-form-1" class="form-label">عنوان</label>
                                <input name="title" id="crud-form-3" type="text" class="form-control w-full {{$errors->has('title') ? 'is-danger' :''}}" value="{{old( 'title' , $view_model->getModelData('title') )}}" placeholder="">
                                @error('title')
                                    <div class="alert-danger-soft">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-3">
                                <label for="crud-form-1" class="form-label">محتوا</label>
                                <textarea name="params[des]"  class="form-control {{$errors->has('params.des') ? 'is-danger' :''}}" rows="10">{{old( 'params.des' , $view_model->getModelDataJson('paramsJson.des') )}}</textarea>
                                @error('params.des')
                                    <div class="alert-danger-soft">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-3">
                                <label for="crud-form-1" class="form-label">لینک</label>
                                <input name="params[link]" id="crud-form-3" type="text" class="form-control w-full {{$errors->has('params.link') ? 'is-danger' :''}}"
                                       value="{{old( 'params.link' , $view_model->getModelDataJson('paramsJson.link') )}}" placeholder="">
                                @error('params.link')
                                    <div class="alert-danger-soft">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mt-3">
                                <label for="crud-form-1" class="form-label">حالت نمایش</label>
                                <select name="type" id="crud-form-3" type="text" class="form-control w-full {{$errors->has('type') ? 'is-danger' :''}}" >
                                    <option value="1" @if( old( 'type' , $view_model->getModelData('type') ) == 1 ) selected @endif>بنر</option>
                                </select>
                                @error('type')
                                    <div class="alert-danger-soft">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-3">
                                <label for="crud-form-1" class="form-label">جایگاه</label>
                                <select name="position" id="crud-form-3" type="text" class="form-control w-full {{$errors->has('position') ? 'is-danger' :''}}" >
                                    <option value="1" @if( old( 'position' , $view_model->getModelData('position') ) == 1 ) selected @endif>place 1</option>
                                    <option value="2" @if( old( 'position' , $view_model->getModelData('position') ) == 2 ) selected @endif>place 2</option>
                                    <option value="3" @if( old( 'position' , $view_model->getModelData('position') ) ==3 ) selected @endif>place 3</option>
                                    <option value="4" @if( old( 'position' , $view_model->getModelData('position') ) ==4 ) selected @endif>place 4</option>
                                    <option value="5" @if( old( 'position' , $view_model->getModelData('position') ) == 5 ) selected @endif>place 5</option>
                                    <option value="6" @if( old( 'position' , $view_model->getModelData('position') ) ==6 ) selected @endif>place 6</option>
                                </select>
                                @error('position')
                                    <div class="alert-danger-soft">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-3">
                                <label for="crud-form-1" class="form-label">مرتب سازی </label>
                                <input name="sort" id="crud-form-3" type="number" class="form-control w-full {{$errors->has('sort') ? 'is-danger' :''}}" value="{{old( 'sort' , $view_model->getModelData('sort') )}}" placeholder="">

                                @error('sort')
                                    <div class="alert-danger-soft">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mt-3">
                                <label for="crud-form-1" class="form-label">تصویر</label>
                                <input name="src" type="file" class="form-control w-full {{ $errors->has('src') ?'is-danger' :'' }}" placeholder="">
                                @if( $view_model->getModelData('src') )
                                    <img src="{{url($view_model->getModelData('src'))  }}" style="width: 300px">
                                @endif
                                @error('src')
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
