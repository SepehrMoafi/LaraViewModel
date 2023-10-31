<div class="bg-light-blue dark:bg-dark-blue p-6 md:p-12 mb-5">
    <form class="mt-4 px-2 md:px-6" method="POST" enctype="multipart/form-data"
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
                        <label>ترتیب</label>
                        <input style="width: 70px" class="form-control" value="{{ $item_obj->sort }}" name="sort"
                               type="number">
                    </div>
                    @if(!isset($block->routeBlockConfig->customerName1))
                        <div class="customer-fields-container" style="margin-top: 10px">
                            <div class="customer-field mt-5">
                                <label for="crud-form-1" class="form-label">نام نظر دهنده</label>
                                <input name="config[customerName1]"
                                       value="{{old( 'customerName1' ,@ $block->routeBlockConfig->customerName1) }}"
                                       id="crud-form-3"
                                       type="text"
                                       class="form-control w-full {{$errors->has('customerName') ? 'is-danger' :''}}">
                            </div>

                            <div class="customer-field mt-5">
                                <label for="crud-form-1" class="form-label">امتیاز</label>
                                <input name="config[point1]" id="crud-form-3" type="number"
                                       value="{{old( 'point1' ,@ $block->routeBlockConfig->point1) }}"
                                       class="form-control w-full {{$errors->has('point') ? 'is-danger' :''}}" min="0"
                                       max="5">
                            </div>

                            <div class="customer-field mt-5">
                                <label for="crud-form-1" class="form-label">عکس</label>
                                <input name="config[image1]" id="crud-form-3" type="file"
                                       class="form-control w-full {{$errors->has('image1') ? 'is-danger' :''}}">
                            </div>

                            <div class="customer-field mt-5">
                                <label for="crud-form-1" class="form-label">متن نظر</label>
                                <input name="config[customerComment1]"
                                       value="{{old( 'customerComment1' ,@ $block->routeBlockConfig->customerComment1) }}"
                                       id="crud-form-3" type="text"
                                       class="form-control w-full {{$errors->has('customerComment') ? 'is-danger' :''}}">
                            </div>
                        </div>
                    @endif
                    @php
                        $groupedData = [];

                        foreach ($block->routeBlockConfig as $key => $value) {
                            preg_match('/\d+$/', $key, $matches);
                            $groupNumber = $matches[0] ?? null;

                            if ($groupNumber) {
                                $groupedData[$groupNumber][$key] = $value;
                            }
                        }
                    @endphp
                    @foreach ($groupedData as $groupKey => $groupData)
                        <div class="customer-fields-container" style="margin-top: 10px">
                            @foreach ($groupData as $key => $value)
                                @if (str_starts_with($key, 'customerName'))
                                    <div class="customer-field mt-5">
                                        <label for="crud-form-1" class="form-label">نام نظر دهنده</label>
                                        <input name="config[{{ $key }}]"
                                               value="{{ old($key, @$block->routeBlockConfig->$key) }}" id="crud-form-1"
                                               type="text"
                                               class="form-control w-full {{ $errors->has('customerName') ? 'is-danger' : '' }}">
                                    </div>
                                @endif

                                @if (str_starts_with($key, 'point'))
                                    <div class="customer-field mt-5">
                                        <label for="crud-form-1" class="form-label">امتیاز</label>
                                        <input name="config[{{ $key }}]" id="crud-form-1" type="number"
                                               value="{{ old($key, @$block->routeBlockConfig->$key) }}"
                                               class="form-control w-full {{ $errors->has('point') ? 'is-danger' : '' }}"
                                               min="0" max="5">
                                    </div>
                                @endif

                                @if (str_starts_with($key, 'image'))
                                    <div class="customer-field mt-5">
                                        <label for="crud-form-1" class="form-label">عکس</label>
                                        <input name="config[{{ $key }}]" id="crud-form-1" type="file"
                                               class="form-control w-full {{ $errors->has('image') ? 'is-danger' : '' }}">
                                    </div>
                                @endif

                                @if (str_starts_with($key, 'customerComment'))
                                    <div class="customer-field mt-5">
                                        <label for="crud-form-1" class="form-label">متن نظر</label>
                                        <input name="config[{{ $key }}]"
                                               value="{{ old($key, @$block->routeBlockConfig->$key) }}" id="crud-form-1"
                                               type="text"
                                               class="form-control w-full {{ $errors->has('comment') ? 'is-danger' : '' }}">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                    <hr> <!-- Add a horizontal rule separator -->

                    <div class="text-left mt-5">
                        <a href="{{ route('admin.core.blocks.remove-route-block-item', ['block_route_item_id' => $block->block_route_item_id]) }}">حذف</a>
                        <button type="submit" class="btn btn-warning w-24">ذخیره</button>
                        <button type="button" class="btn btn-primary clone-customer-field">کپی
                            کردن
                        </button>
                    </div>
                </div>
                <!-- END: Form Layout -->
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var cloneButton = document.querySelector('.clone-customer-field');
        var customerFieldsContainer = document.querySelector('.customer-fields-container');
        var customerFieldTemplate = customerFieldsContainer.cloneNode(true);
        var cloneCount = {{ isset($block->routeBlockConfig->customerName1) ? count((array) $block->routeBlockConfig)/4 + 1 : 2 }}; // Start the count from 2 to match the desired naming

        cloneButton.addEventListener('click', function () {
            var clonedField = customerFieldTemplate.cloneNode(true);
            updateAttributeNames(clonedField, cloneCount); // Update attribute names
            customerFieldsContainer.appendChild(clonedField);
            cloneCount++;
        });

        function updateAttributeNames(field, count) {
            var inputs = field.querySelectorAll('input');
            inputs.forEach(function (input) {
                var currentName = input.getAttribute('name');
                var newName = currentName.slice(0, -2) + count + ']';
                input.setAttribute('name', newName);
                input.value = ''; // Clear the input value for the cloned fields
            });
        }
    });

</script>
