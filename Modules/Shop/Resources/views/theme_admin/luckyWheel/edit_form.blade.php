@extends('core::theme_admin.layouts.app')

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <h3 class="font-bold text-blue-900 text-4xl w-9/12 leading-loose my-5">گردونه شانس</h3>
            </div>
        </div>
        <div class="row">
            <form action="{{ route('admin.shop.luckyWheel.update' ,$gift->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="mb-4 col-6">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">عنوان:</label>
                    <input type="text" name="title" id="title" class="w-full px-3 py-2 border border-gray-300 rounded" value="{{old( 'title' , $gift->title )}}"
                           required>
                    @error('title')
                    <div class="text-red-500 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4 col-6">
                    <label for="product_catalog_id" class="block text-gray-700 text-sm font-bold mb-2">گردونه شانس برای محصول :</label>
                    <select name="product_catalog_id" id="product_id" class="w-full " >
                        <option class="px-5 mx-5" selected> انتخاب محصول</option>
                        @foreach($products as $product)
                            <option class="px-5 mx-5" @selected($gift->product_catalog_id == $product->id) value="{{ $product->id }}">{{ $product->title }}</option>
                        @endforeach
                    </select>
                    @error('product_catalog_id')
                    <div class="text-red-500 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="my-10">

                <div class="mb-4 col-6">
                    <label for="product_catalog_id" class="block text-gray-700 text-sm font-bold mb-2">آیتم محصول برای گردونه</label>

                    <select name="products[]" id="products" class="w-full " multiple >
                        @foreach($products as $product)
                            <option class="px-5 mx-5" @selected($giftItems->where('itemable_type','Modules\Shop\Entities\ProductCatalog')->where('itemable_id',$product->id)->first() !== null) value="{{ $product->id }}">{{ $product->title }}</option>
                        @endforeach
                    </select>
                    @error('product_catalog_id.*')
                    <div class="text-red-500 mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4 col-6">
                    <label for="discount_code" class="block text-gray-700 text-sm font-bold mb-2">آیتم کد تخفیف برای گردونه</label>
                    <select name="discount_code[]" id="discount_code" class="w-full px-3 py-2 border border-gray-300 rounded" multiple >
                        @foreach($copans as $copan)
                            <option value="{{ $copan->id }}" @if($giftItems->where('itemable_type','Modules\Shop\Entities\Copan')->where('itemable_id',$copan->id)->first() !== null) selected @endif>{{ $copan->code }}</option>
                        @endforeach
                    </select>
                    @error('discount_code.*')
                    <div class="text-red-500 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="sm:mr-auto mt-3 sm:mt-0 relative text-gray-700 dark:text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                         stroke-linejoin="round"
                         class="feather feather-calendar w-4 h-4 z-10 absolute my-auto inset-y-0 mr-3 right-0">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <input type="text" name="date" class="datepicker form-control sm:w-56 box pr-10 {{$errors->has('date') ? 'is-danger' :''}}">
                    @error('date')
                    <span class="alert-danger-soft mt-2">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4 col-6">
                    <label for="maximum_use" class="block text-gray-700 text-sm font-bold mb-2">حداکثر استفاده:</label>
                    <input type="number" name="maximum_use" id="maximum_user" min="1"
                           value="{{old( 'title' , $gift->maximum_use )}}"
                           class="w-full px-3 py-2 border border-gray-300 rounded" required>
                    @error('maximum_use')
                    <span class="alert-danger-soft mt-2">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-black border font-bold py-2 px-4 rounded">
                    بروزرسانی كردن
                </button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#products').select2();
            $('#discount_code').select2();
        });
    </script>
@endsection
