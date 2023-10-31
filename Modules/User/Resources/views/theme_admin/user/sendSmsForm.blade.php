@extends('core::theme_admin.layouts.app')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="content">
        <div class="mt-4">
            <form action="{{ route('admin.user.send-sms') }}" method="POST">
                @csrf
                <select id="user-select" multiple
                        name="users[]"
                        class="w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-blue-400 focus:ring focus:ring-blue-200">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>

                <div class="mt-4">
                <textarea
                    name="message"
                    class="w-full h-20 p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-400 focus:ring focus:ring-blue-200"
                    placeholder="پیام خود را وارد نمایید"></textarea>
                </div>

                <div class="mt-4">
                    <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        ارسال پیام
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#user-select').select2();
        });
    </script>
@endsection
