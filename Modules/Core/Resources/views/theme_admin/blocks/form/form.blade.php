<div class="bg-light-blue dark:bg-dark-blue p-6 md:p-12 mb-5">
    <form class="mt-4 px-2 md:px-6"
          method="POST"
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
                    <div class="sm:grid" style="margin-top: 10px">
                        <div class="mt-5 ">
                            <label for="crud-form-1" class="form-label">تایتل فرم</label>
                            <input name="config[title]"  id="crud-form-3" type="text"
                                   class="form-control w-100 w-full {{$errors->has('title') ? 'is-danger' :''}}">
                        </div>

                        <div class="mt-5 ">
                            <label for="crud-form-1" class="form-label">تایپ</label>
                            <input name="config[type]"  id="crud-form-3" type="text"
                                   class="form-control w-100 w-full {{$errors->has('type') ? 'is-danger' :''}}">
                        </div>

                        <div class="sm:grid grid-cols-2 gap-2" style="margin-top: 10px">
                            <button id="addInputsButton" type="button" class="btn " style="background-color: #efb7a2">
                                اضافه کردن اینپوت
                            </button>
                        </div>
                        <div id="inputContainer" class="mt-4"></div>

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
<script>
    var inputCount = 1; // Counter for auto-incrementing input IDs

    document.getElementById('addInputsButton').addEventListener('click', function() {
        var inputContainer = document.getElementById('inputContainer');

        var input1 = document.createElement('input');
        input1.classList.add('form-control', 'p-2', 'rounded', 'mb-2');
        input1.placeholder = 'Input Label ' + inputCount;
        input1.name = 'config[inputLabel' + inputCount + ']';
        inputContainer.appendChild(input1);

        var input2 = document.createElement('input');
        input2.classList.add('form-control', 'p-2', 'rounded', 'mb-10');
        input2.placeholder = 'Input Name ' + inputCount;
        input2.name = 'config[inputName' + inputCount + ']';
        inputContainer.appendChild(input2);

        inputCount++; // Increment the counter
    });
</script>
