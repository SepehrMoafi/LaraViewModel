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
                        <label for="sort">ترتیب</label>
                        <input style="width: 70px" class="form-control" value="{{ $item_obj->sort }}" name="sort"
                               id="sort" type="number">
                    </div>
                    <div class="sm:grid" style="margin-top: 10px">
                        <div class="mt-5">
                            <label for="crud-form-1" class="form-label">عنوان</label>
                            <input name="config[title]"
                                   value="{{ old( 'title' ,@ $block->routeBlockConfig->title) }}"
                                   id="crud-form-1" type="text"
                                   class="form-control w-100 w-full {{$errors->has('title') ? 'is-danger' :''}}">
                        </div>

                        <div class="mt-5">
                            <label for="crud-form-2" class="form-label">متن</label>
                            <input name="config[description]"
                                   value="{{ old( 'description' ,@ $block->routeBlockConfig->description) }}" id="crud-form-2"
                                   type="text"
                                   class="form-control w-100 w-full {{$errors->has('description') ? 'is-danger' :''}}">
                        </div>
                        @if(!isset($block->routeBlockConfig->question))
                            <div class="mt-5">
                                <label for="crud-form-1" class="form-label">سوال</label>
                                <input name="config[question]"
                                       value="{{ old( 'question' ,@ $block->routeBlockConfig->question) }}"
                                       id="crud-form-1" type="text"
                                       class="form-control w-100 w-full {{$errors->has('question') ? 'is-danger' :''}}">
                            </div>

                            <div class="mt-5">
                                <label for="crud-form-2" class="form-label">جواب</label>
                                <input name="config[answer]"
                                       value="{{ old( 'answer' ,@ $block->routeBlockConfig->answer) }}" id="crud-form-2"
                                       type="text"
                                       class="form-control w-100 w-full {{$errors->has('answer') ? 'is-danger' :''}}">
                            </div>
                        @endif

                        @foreach ($block->routeBlockConfig as $key => $value)
                            @if (str_starts_with($key, 'question'))
                                <div class="mt-5">
                                    <label for="crud-form-1" class="form-label">سوال</label>
                                    <input name="config[{{ $key }}]"
                                           value="{{ old($key, @$block->routeBlockConfig->$key) }}" id="crud-form-1"
                                           type="text"
                                           class="form-control w-100 w-full {{ $errors->has('title') ? 'is-danger' : '' }}">
                                </div>
                            @endif

                            @if (str_starts_with($key, 'answer'))
                                <div class="mt-5">
                                    <label for="crud-form-2" class="form-label">جواب</label>
                                    <input name="config[{{ $key }}]"
                                           value="{{ old($key, @$block->routeBlockConfig->$key) }}" id="crud-form-2"
                                           type="text"
                                           class="form-control w-100 w-full {{ $errors->has('description') ? 'is-danger' : '' }}">
                                </div>
                            @endif
                        @endforeach


                        <div class="sm:grid grid-cols-2 gap-2" style="margin-top: 10px">
                            <button id="addFaq" type="button" class="btn" style="background-color: #efb7a2"
                                    onclick="addFaq()">اضافه کردن سوال
                            </button>
                        </div>
                        <div id="showFaq" class="mt-4"></div>
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

@section('scripts')
    <script>
        function addFaq() {
            var showFaq = document.getElementById('showFaq');

            var inputLabel1 = document.createElement('input');
            inputLabel1.classList.add('form-control', 'p-2', 'rounded', 'mb-2');
            inputLabel1.placeholder = 'سوال 1';
            showFaq.appendChild(inputLabel1);

            var inputLabel2 = document.createElement('input');
            inputLabel2.classList.add('form-control', 'p-2', 'rounded', 'mb-2');
            inputLabel2.placeholder = 'سوال 2';
            showFaq.appendChild(inputLabel2);
        }
    </script>

    <script>
        var faqCount = {{ isset($block->routeBlockConfig->question) ? count((array) $block->routeBlockConfig)/2 + 1 : 2 }}; // Counter for auto-incrementing input IDs

        document.getElementById('addFaq').addEventListener('click', function () {
            var inputContainer = document.getElementById('showFaq');

            var input1 = document.createElement('input');
            input1.classList.add('form-control', 'p-2', 'rounded', 'mb-2');
            input1.placeholder = 'سوال ' + faqCount;
            input1.name = 'config[question' + faqCount + ']';
            inputContainer.appendChild(input1);

            var input2 = document.createElement('input');
            input2.classList.add('form-control', 'p-2', 'rounded', 'mb-10');
            input2.placeholder = 'جواب ' + faqCount;
            input2.name = 'config[answer' + faqCount + ']';
            inputContainer.appendChild(input2);

            faqCount++; // Increment the counter
        });
    </script>
@endsection
