@extends('core::theme_admin.layouts.app')

@section('content')
    <div class="content">
        <div class="intro-y flex items-center mt-8">

        </div>
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Profile Menu -->

            <!-- END: Profile Menu -->
            <div class="col-span-12 lg:col-span-12 xxl:col-span-12">
                <!-- BEGIN: Display Information -->
                <div class="intro-y box lg:mt-5">

                    <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-medium text-base ml-auto">
                            نمایش اطلاعات
                        </h2>
                    </div>


                    <div class="px-5 sm:px-16 py-10 sm:py-20">
                        <p class="text-lg font-medium text-theme-17 dark:text-gray-300 mt-2"> تراکنش ها </p>
                        <div class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                <tr>
{{--                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">توضیحات</th>--}}
                                    <th class="border-b-2 dark:border-dark-5 text-left whitespace-nowrap">نوع</th>
                                    <th class="border-b-2 dark:border-dark-5 text-left whitespace-nowrap">مبلغ</th>
                                    <th class="border-b-2 dark:border-dark-5 text-left whitespace-nowrap">تاریخ</th>
                                    <th class="border-b-2 dark:border-dark-5 text-left whitespace-nowrap">وضعیت</th>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse($transactions as $item)
                                    <tr>
{{--                                        <td class="border-b dark:border-dark-5">--}}
{{--                                            <div class="font-medium whitespace-nowrap"></div>--}}
{{--                                            <div class="text-gray-600 text-sm mt-0.5 whitespace-nowrap"></div>--}}
{{--                                        </td>--}}
                                        <td class="text-left border-b dark:border-dark-5 w-32">@if($item->transaction_type == 'debtor') شارژ کیف پول @else دریافت از کیف پول @endif</td>
                                        <td class="text-left border-b dark:border-dark-5 w-32">{{$item->amount }}  تومان </td>
                                        <td class="text-left border-b dark:border-dark-5 w-32 font-medium">{{ jdate($item->created_at )->format('Y-m-d') }}</td>
                                        <td class="text-left border-b dark:border-dark-5 w-32 font-medium">{!!   $item->payment->status_text_badage !!}</td>
                                    </tr>
                                @empty

                                @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>

{{--                    <div class="p-5">--}}
{{--                        <div class="flex flex-col-reverse xl:flex-row flex-col">--}}
{{--                            <div class="flex-1 mt-6 xl:mt-0">--}}
{{--                                <h3>اقزودن سند پرداخت</h3>--}}
{{--                                <br>--}}
{{--                                <form action="">--}}
{{--                                <div class="grid grid-cols-12 gap-x-5">--}}

{{--                                    <div class="col-span-12 xxl:col-span-6">--}}
{{--                                        <div>--}}
{{--                                            <label for="update-profile-form-1" class="form-label">مبلغ</label>--}}
{{--                                            <input id="update-profile-form-1" type="text" class="form-control" placeholder="" value="">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-span-12 xxl:col-span-6">--}}
{{--                                        <div class="mt-3">--}}
{{--                                            <label for="update-profile-form-4" class="form-label">تصویر</label>--}}
{{--                                            <input id="update-profile-form-4" type="file" class="form-control">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}


{{--                                </div>--}}

{{--                                <button type="button" class="btn btn-primary w-20 mt-3">ثبت</button>--}}
{{--                                </form>--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}

                </div>
                <!-- END: Display Information -->
            </div>
        </div>
    </div>
@endsection
