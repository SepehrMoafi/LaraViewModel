@extends('core::theme_admin.layouts.app')

@section('content')
    <div class="content">
        <form @if(! $view_model->getModelData('id') ) action="{{ route('admin.core.blocks.store') }}" method="POST"
              @else action="{{ route('admin.core.blocks.update' , $view_model->getModelData('id') ) }}"
              method="POST" @endif  enctype="multipart/form-data">
            @csrf
            @if( $view_model->getModelData('id') ) @method('PUT') @endif

            <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                <h2 class="text-lg font-medium ml-auto">
                      مدیریت صفحات
                </h2>

                <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                    <button class="mr-2 btn btn-primary shadow-md flex items-center" aria-expanded="false" type="submit"> ذخیره </button>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="intro-y col-span-12 lg:col-span-12">
                    <!-- BEGIN: Form Layout -->
                    <div class="intro-y box p-5">


                        <div class="mt-3">
                            <label class="form-label">انتخاب صفحه</label>
                            <input name="route_name" class="form-control {{$errors->has('route_name') ? 'is-danger' :''}}" value="{{ $view_model->getModelData('route_name') }}">
                            @error('product_catalog_id')
                            <div class="alert-danger-soft">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mt-3">

                            <div class="sm:grid grid-cols-3 gap-2">
                                <div class="input-group mt-2 sm:mt-0">
                                    <div id="input-group-4" class="input-group-text">عنوان </div>
                                    <input type="text" class="form-control {{$errors->has('title') ? 'is-danger' :''}}" name="title" value="{{ old( 'title' , $view_model->getModelData('title') ) }}" aria-describedby="input-group-4">
                                </div>
                                @error('title')
                                <div class="alert-danger-soft">{{ $message }}</div>
                                @enderror
                            </div>

                            @if( $view_model->getModelData('id') )
                                <div class="sm:grid grid-cols-3 gap-2" style="margin-top: 10px">
                                    @foreach( $view_model->getBlockList() as $block_item)
                                        <a href="{{ route('admin.core.blocks.add-block-to-route-block' , ['block_id' =>$block_item->id , 'route_block_id' => $view_model->getModelData('id') ]) }}" class="btn btn-warning mt-2">{{ $block_item->title }}</a>
                                    @endforeach
                                </div>
                            @endif

                        </div>

                        <div class="text-left mt-5">
                            <button type="submit" class="btn btn-primary w-24">ذخیره</button>
                        </div>

                    </div>
                    <!-- END: Form Layout -->
                </div>
            </div>

        </form>

        @if( $view_model->getModelData('blocks') )
            <div class="sm:grid grid-cols-1 gap-2" style="margin-top: 10px">
                @foreach( $view_model->getModelData('blocks') as $a_block_item)
                    @php
                        $block_obj = $view_model->getBlockList()->where('id' , $a_block_item->block_id)->first();
                        $block_class = new $block_obj->class($a_block_item->id  );
                    @endphp
                    <div>
                        {!! $block_class->renderAdmin() !!}
                    </div>
                @endforeach
            </div>
        @endif


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
