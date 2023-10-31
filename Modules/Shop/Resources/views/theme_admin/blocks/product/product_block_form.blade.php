<div class="content" style="min-height:fit-content">
    <form action="{{ route('admin.core.blocks.update-route-block-item-config' , [ 'block_route_item_id' =>$block->block_route_item_id , 'route_block_id' =>$block->route_block_id ,  ] ) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 lg:col-span-12">
                <!-- BEGIN: Form Layout -->
                <div class="intro-y box p-5">
                    <div style="text-align: center">
                        <p>
                            {{ $block->title }}
                        </p>
                    </div>
                    <div>
                        <lable>ترتیب</lable>
                        <input style="width: 70px" class="form-control" value="{{$item_obj->sort}}" name="sort" type="number">
                    </div>
                    <div class="sm:grid grid-cols-2 gap-2" style="margin-top: 10px">
                        <div class="mt-5">
                            <label for="crud-form-1" class="form-label">نوع نمایش</label>
                            <select name="config[template]" id="crud-form-3" type="text" class="form-control w-full" >
                                <option value="product_slide" @if( @ $block->routeBlockConfig->slider_position == 'product_slide' ) selected @endif> نمایش اسلایدی </option>
                            </select>
                        </div>

                        <div class="mt-5">
                            <lable>عنوان</lable>
                            <input class="form-control" value="{{@ $block->routeBlockConfig->title}}" name="config[title]" type="text">
                        </div>

                        <div class="mt-5">
                            <lable>رنگ</lable>
                            <input style="height: 40px" class="form-control" value="{{@ $block->routeBlockConfig->color}}" name="config[color]" type="color">
                        </div>

                        <div class="mt-5 ">
                            <label class="form-label">محصول</label>
                            <select name="config[products][]" data-search="true" class="form-control js-select-2" multiple>
                                @php
                                    $products = \Modules\Shop\Entities\ProductCatalog::query()->get();
                                @endphp
                                @foreach( $products as $post)
                                    <option @if( @ $block->routeBlockConfig->products &&  in_array($post->id , $block->routeBlockConfig->products ) ) selected @endif value="{{ $post->id }}"> {{ $post->title }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-5 ">
                            <label class="form-label">دسته بندی</label>
                            <select name="config[category][]" data-search="true" class="form-control js-select-2" multiple>
                                @php
                                    $cats = \Modules\Shop\Entities\ProductCatalogCategory::query()->get();
                                @endphp
                                @foreach( $cats as $post)
                                    <option @if(@ $block->routeBlockConfig->category &&  in_array($post->id , $block->routeBlockConfig->category ) ) selected @endif value="{{ $post->id }}"> {{ $post->title }} </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="text-left mt-5">
                        <a href="{{ route('admin.core.blocks.remove-route-block-item' , [ 'block_route_item_id' => $block->block_route_item_id ] )  }}"> حذف </a>
                        <button type="submit" class="btn btn-warning w-24">ذخیره</button>
                    </div>

                </div>
                <!-- END: Form Layout -->
            </div>
        </div>

    </form>

</div>
