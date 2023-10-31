<div class="bg-light-blue dark:bg-dark-blue p-6 md:p-12 mb-5">
    <form class="mt-4 px-2 md:px-6"
          method="POST"
          enctype="multipart/form-data"
          action="{{ route('admin.core.blocks.update-route-block-item-config', ['block_route_item_id' => $block->block_route_item_id, 'route_block_id' => $block->route_block_id]) }}">
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
                        <input style="width: 70px" class="form-control" value="{{ $item_obj->sort }}" name="sort" type="number">
                    </div>

                    <div class="mt-5">
                        <label for="crud-form-1" class="form-label">نوع نمایش</label>
                        <select name="config[template]" id="crud-form-3" type="text" class="form-control w-full" >
                            <option value="place_1" @if( @ $block->routeBlockConfig->template == 'place_1' ) selected @endif> نمایش 1 </option>
                            <option value="place_2" @if( @ $block->routeBlockConfig->template == 'place_2' ) selected @endif> نمایش 2 </option>
                        </select>
                    </div>

                    <div class="sm:grid grid-cols-2 gap-2" style="margin-top: 10px">
                        <div class="mt-5 ">
                            <label for="crud-form-1" class="form-label">عنوان</label>
                            <input name="config[title]" value="{{old( 'text1' ,@ $block->routeBlockConfig->title) }}" id="crud-form-3" type="text"
                                   class="form-control {{$errors->has('title') ? 'is-danger' :''}}">
                        </div>
                    </div>

                    <div class="sm:grid grid-cols-2 gap-2" style="margin-top: 10px">
                        <div class="mt-5">
                            <label for="crud-form-1" class="form-label">متن1</label>
                            <input name="config[text1]" value="{{old( 'text1' ,@ $block->routeBlockConfig->text1) }}" id="crud-form-3" type="text"
                                   class="form-control w-full {{$errors->has('position') ? 'is-danger' :''}}">
                        </div>

                        <div class="mt-5">
                            <label for="crud-form-1" class="form-label">آیکون1</label>
                            <input name="config[icon1]" id="crud-form-3" type="file"
                                   class="form-control w-full {{$errors->has('position') ? 'is-danger' :''}}">

                        </div>

                        <div class="mt-5">
                            <label for="crud-form-1" class="form-label">متن2</label>
                            <input name="config[text2]" value="{{old( 'text2' ,@ $block->routeBlockConfig->text2) }}" id="crud-form-3" type="text"
                                   class="form-control w-full {{$errors->has('position') ? 'is-danger' :''}}">

                        </div>

                        <div class="mt-5">
                            <label for="crud-form-1" class="form-label">آیکون2</label>
                            <input name="config[icon2]" id="crud-form-3" type="file"
                                   class="form-control w-full {{$errors->has('position') ? 'is-danger' :''}}">

                        </div>

                        <div class="mt-5">
                            <label for="crud-form-1" class="form-label">متن3</label>
                            <input name="config[text3]" value="{{old( 'text3' ,@ $block->routeBlockConfig->text3) }}" id="crud-form-3" type="text"
                                   class="form-control w-full {{$errors->has('position') ? 'is-danger' :''}}">

                        </div>

                        <div class="mt-5">
                            <label for="crud-form-1" class="form-label">آیکون3</label>
                            <input name="config[icon3]" id="crud-form-3" type="file"
                                   class="form-control w-full {{$errors->has('position') ? 'is-danger' :''}}">
                        </div>

                        <div class="mt-5">
                            <label for="crud-form-1" class="form-label">متن4</label>
                            <input name="config[text4]" value="{{old( 'text3' ,@ $block->routeBlockConfig->text4) }}" id="crud-form-3" type="text"
                                   class="form-control w-full {{$errors->has('position') ? 'is-danger' :''}}">

                        </div>

                        <div class="mt-5">
                            <label for="crud-form-1" class="form-label">آیکون4</label>
                            <input name="config[icon4]" id="crud-form-3" type="file"
                                   class="form-control w-full {{$errors->has('position') ? 'is-danger' :''}}">
                        </div>

                    </div>


                    <div class="text-left mt-5">
                        <a href="{{ route('admin.core.blocks.remove-route-block-item', ['block_route_item_id' => $block->block_route_item_id]) }}">
                            حذف
                        </a>
                        <button type="submit" class="btn btn-warning w-24">ذخیره</button>
                    </div>

                </div>
                <!-- END: Form Layout -->
            </div>
        </div>

    </form>
</div>
