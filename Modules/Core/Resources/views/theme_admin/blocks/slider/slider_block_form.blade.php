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
                            <label for="crud-form-1" class="form-label">جایگاه</label>
                            <select name="config[slider_position]" id="crud-form-3" type="text" class="form-control w-full {{$errors->has('position') ? 'is-danger' :''}}" >
                                <option value="1" @if( @ $block->routeBlockConfig->slider_position == 1 ) selected @endif>place 1</option>
                                <option value="2" @if( @ $block->routeBlockConfig->slider_position == 2 ) selected @endif>place 2</option>
                                <option value="3" @if( @ $block->routeBlockConfig->slider_position == 3 ) selected @endif>place 3</option>
                                <option value="4" @if( @ $block->routeBlockConfig->slider_position == 4 ) selected @endif>place 4</option>
                                <option value="5" @if( @ $block->routeBlockConfig->slider_position == 5 ) selected @endif>place 5</option>
                                <option value="6" @if( @ $block->routeBlockConfig->slider_position == 6 ) selected @endif>place 6</option>
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

