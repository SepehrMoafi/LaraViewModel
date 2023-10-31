@extends('core::theme_admin.layouts.app')

@section('content')
    <div class="content">
        <div class="w-full max-w-lg mx-auto mt-8">
            <div class="bg-white rounded-lg shadow-md">

                <div class="bg-white rounded-lg shadow-md">
                    <div class="px-6 py-4 bg-gray-100 border-b">
                        <h2 class="text-lg font-semibold">ویرایش دپارتمان</h2>
                    </div>

                    <div class="px-6 py-4">
                        <form action="{{ route('admin.user.departments.update', $department->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label class="block font-semibold mb-2">نام دپارتمان:</label>
                                <input type="text" name="name" value="{{ $department->name }}" class="w-full p-2 border rounded-md focus:outline-none focus:ring focus:border-blue-500">
                            </div>
                            <button type="submit" class="btn btn-sm  px-4 py-2 rounded-lg focus:outline-none focus:ring " style="background: #abf3ff;">ذخیره تغییرات</button>
                        </form>
                    </div>
                </div>

                    </div>
                </div>
            </div>
        </div>
@endsection
