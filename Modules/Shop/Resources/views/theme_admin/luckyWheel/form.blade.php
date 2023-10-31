@extends('core::theme_admin.layouts.app')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <h3 class="font-bold text-blue-900 text-4xl w-9/12 leading-loose my-5">گردونه شانس</h3>
            </div>
        </div>
        <div class="row">
            <form action="" method="POST">
                @csrf
                <div class="mb-4 col-6">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">عنوان:</label>
                    <input type="text" name="title" id="title" class="w-full px-3 py-2 border border-gray-300 rounded"
                           required>
                </div>

                <div class="mb-4 col-6">
                    <label for="product_catalog_id" class="block text-gray-700 text-sm font-bold mb-2">محصول</label>
                    <select name="product_catalog_id" id="product_catalog_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded" required>
                        <option value="">Select a product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4 col-6">
                    <label for="active_date" class="block text-gray-700 text-sm font-bold mb-2">تاریخ فعال:</label>
                    <input type="date" name="active_date" id="active_date"
                           class="w-full px-3 py-2 border border-gray-300 rounded" required>
                </div>
                <div class="mb-4 col-6">
                    <label for="expire_date" class="block text-gray-700 text-sm font-bold mb-2">تاریخ انقضا:</label>
                    <input type="date" name="expire_date" id="expire_date"
                           class="w-full px-3 py-2 border border-gray-300 rounded" required>
                </div>
                <div class="mb-4 col-6">
                    <label for="maximum_user" class="block text-gray-700 text-sm font-bold mb-2">حداکثر استفاده:</label>
                    <input type="number" name="maximum_user" id="maximum_user"
                           class="w-full px-3 py-2 border border-gray-300 rounded" required>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-black border font-bold py-2 px-4 rounded">
                    ايجاد كردن
                </button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
