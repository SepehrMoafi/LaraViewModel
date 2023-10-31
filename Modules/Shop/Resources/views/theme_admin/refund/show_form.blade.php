@extends('core::theme_admin.layouts.app')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <h3 class="font-bold text-blue-900 text-4xl w-9/12 leading-loose my-5">بازگشت وجه</h3>
            </div>
        </div>
        <div class="row">
            <form action="{{ route('admin.shop.refund.approve' ,$refund->id) }}" method="POST">
                @method('PUT')
                @csrf

                <div class="mt-6">
                    <label for="status" class="block text-sm font-medium text-gray-700">وضعیت</label>
                    <select name="status" id="status" disabled
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="0" {{ old('status',$refund->status) == 0 ? 'selected' : '' }}>در انتظار تایید</option>
                        <option value="1" {{ old('status',$refund->status) == 1 ? 'selected' : '' }}>پرداخت شده</option>
                        <option value="2" {{ old('status',$refund->status) == 2 ? 'selected' : '' }}>رد شده</option>
                    </select>
                    @error('status')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="status" class="block text-sm font-medium text-gray-700">تاییدیه</label>
                    <select name="approved" id="status"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="0" {{ old('status',$refund->approved) == 0 ? 'selected' : '' }}>در انتظار تایید
                        </option>
                        <option value="1" {{ old('status',$refund->approved) == 1 ? 'selected' : '' }}>تایید</option>
                        <option value="2" {{ old('status',$refund->approved) == 2 ? 'selected' : '' }}>رد کردن</option>
                    </select>
                    @error('status')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700">متن برای کاربر</label>
                    <input type="text" name="notes" id="notes" value="{{ old('notes',$refund->notes) }}"
                           class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('notes')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="user_id" class="block text-sm font-medium text-gray-700">کاربر متقاضی</label>
                    <input type="text" disabled name="user_id" id="user_id" value="{{ old('user_id',$refund->user->name) }}"
                           class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('user_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="order_item_id" class="block text-sm font-medium text-gray-700">نام کالا</label>
                    <input type="text" disabled name="order_item_id" id="order_item_id" value="{{ old('order_item_id',$refund->orderItem->product()->catalog->title) }}"
                           class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('order_item_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="amount" class="block text-sm font-medium text-gray-700">مقدار وجه بازگشتی</label>
                    <input type="text" disabled name="amount" id="amount" value="{{ old('amount',$refund->amount) }}"
                           class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('amount')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="reason" class="block text-sm font-medium text-gray-700">دلیل</label>
                    <textarea name="reason" disabled id="reason"
                              class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('reason',$refund->reason) }}</textarea>
                    @error('reason')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="refund_method" class="block text-sm font-medium text-gray-700">روش پرداخت</label>
                    <input type="text" disabled name="refund_method" id="refund_method"
                           value="{{ old('refund_method',$refund->refund_method) }}"
                           class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('refund_method')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="qty" class="block text-sm font-medium text-gray-700">تعداد</label>
                    <input type="number" disabled name="qty" id="qty" value="{{ old('qty',$refund->qty) }}"
                           class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('qty')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="text-center mt-6">
                    <button type="submit"
                            class="bg-green-300 hover:bg-blue-700 text-black border font-bold py-2 px-4 rounded">
                        بروزرسانی كردن
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
