@extends('core::theme_master.layouts.app')

@section('content')
    <!-------- Content  ------->
    <main>
        <div class="flex flex-col lg:flex-row justify-between gap-10 w-4/12 mx-auto my-8">




            <form style="width: 100%" method="POST" action="{{ route('login') }}">
                @csrf
                <p> <span>حساب کاربری ندارید ؟ </span> <a href="{{ route('register') }}"> ثبت نام کنید </a> </p>
                <!-- Email Address -->
                <div>
                    <label>ایمیل</label>
                    <x-text-input id="email" class="block mt-1 w-full form-control"
                    style="border-color: #eee;"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label>رمز عبور</label>

                    <x-text-input id="password" class="block mt-1 w-full form-control"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password"
                    style="border-color: #eee;"
                                    
                                    />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ml-2 text-sm text-white-600">{{ __('من را به خاطر بسپار') }}</span>
                    </label>

                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a style="margin-left: 15px;" class="underline text-sm text-white-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            {{ __('بازیابی رمزعبور ') }}
                        </a>
                    @endif

                    <x-primary-button class="ml-3">
                        {{ __('ورود') }}
                    </x-primary-button>
                </div>
            </form>

        </div>
    </main>
@endsection
