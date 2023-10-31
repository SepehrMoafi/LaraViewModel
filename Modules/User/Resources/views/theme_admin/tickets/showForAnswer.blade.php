@extends('core::theme_admin.layouts.app')

@section('content')
    <div class="content">
        <div class="w-full max-w-lg mx-auto mt-8">
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 bg-gray-100 border-b">
                    <h2 class="text-lg font-semibold">اطلاعات پیام</h2>
                </div>

                <div class="px-6 py-4">
                    <p class="my-4"><strong>عنوان:</strong> <b>{{ $ticket->title }}</b></p>
                    <p class="my-4"><strong>متن:</strong> <b>{{ $ticket->description }}</b></p>
                    <p class="my-4"><strong>وضعیت:</strong> <b>{{ $ticket->status }}</b></p>
                    <p class="my-4"><strong>دپارتمان:</strong> <b>{{ $ticket->department->name }}</b></p>

                    <div class="px-6 py-4">
                        <form action="{{ route('admin.user.ticket_answer.store', $ticket->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="response" class="block text-gray-700 font-semibold mb-2">پاسخ ادمین:</label>
                                <textarea id="response" name="response"
                                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500 @error('response') border-red-500 @enderror"
                                          rows="4">{{ old('response') }}</textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit"
                                        class="btn btn-lg btn-facebook text-black rounded-md mx-auto block">ارسال پاسخ
                                </button>
                            </div>
                        </form>

                        <h4 class="text-lg font-semibold mt-4 my-5">پاسخ ها</h4>
                        @foreach ($ticket->ticketanswers as $answer)
                            <div class="bg-white rounded-lg shadow-md mb-4">
                                <div class="px-6 py-3 bg-gray-100 border-b">
                                    <p class="text-sm text-gray-600">پاسخ توسط : <b> @if($answer->ticket->user->id == $answer->user_id) مشتری @else {{ $answer->user->name }}  @endif </b></p>
                                    <p class="text-sm text-gray-600"> در تاریخ :
                                        <b>{{ jdate($answer->created_at)->format('Y-m-d H:i') }}</b></p>
                                </div>
                                <div class="px-6 py-4">
                                    <p class="text-gray-700 bg-danger rounded-lg p-3" style="@if($answer->ticket->user->id == $answer->user_id) background-color: #dbffdb @else background-color: #f0f5c4 @endif ">{{ $answer->response }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
@endsection
