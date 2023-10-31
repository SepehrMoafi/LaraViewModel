@extends('core::theme_master.layouts.app')

@section('content')
    <!-------- Content  ------->
    <main>
        <div class="flex flex-col lg:flex-row justify-between gap-10 w-4/12 mx-auto my-8">


            <form style="width:100%" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('نام')" />
                    <x-text-input id="name"
                    style="border-color: #eee;"
                    class="block mt-1 w-full form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('ایمیل')" />
                    <x-text-input id="email"
                    style="border-color: #eee;"
                    class="block mt-1 w-full form-control" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="mobile" :value="__('موبایل')" />
                    <x-text-input id="mobile"
                    style="border-color: #eee;"
                    class="block mt-1 w-full form-control" type="text" name="mobile" :value="old('mobile')" required autofocus autocomplete="mobile" />
                    <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('رمزعبور')" />

                    <x-text-input id="password" class="block mt-1 w-full form-control"
                    style="border-color: #eee;"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('تکرار رمزعبور')" />

                    <x-text-input id="password_confirmation" class="block mt-1 w-full form-control"
                                    type="password"
                                    style="border-color: #eee;"
                                    name="password_confirmation" required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a style="margin-left: 20px; color : white" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                        {{ __('اگر حساب کاربری دارید وارد شوید') }}
                    </a>

                    <x-primary-button class="ml-4"
                    style="background-color: dimgray;"
                    >
                        {{ __('ثبت نام') }}
                    </x-primary-button>
                </div>
            </form>

        </div>
    </main>
@endsection

