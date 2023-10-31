@extends('core::theme_admin.layouts.app')

@section('content')

    <div class="content">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 xxl:col-span-9">
                <div class="grid grid-cols-12 gap-6">
                    <!-- BEGIN: General Report -->
                    <div class="col-span-12 mt-8">
                        <div class="intro-y flex items-center h-10">
                            <h2 class="text-lg font-medium truncate ml-5">
                                گزارش کلی
                            </h2>
{{--                            <a href="" class="mr-auto flex items-center text-theme-26 dark:text-theme-33"> <i data-feather="refresh-ccw" class="w-4 h-4 ml-3"></i> به روزرسانی داده </a>--}}
                        </div>
                        <div class="grid grid-cols-12 gap-6 mt-5">
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="shopping-cart" class="report-box__icon text-theme-21"></i>
                                            <div class="mr-auto">
{{--                                                <div class="report-box__indicator bg-theme-10 tooltip cursor-pointer" title="33% بالاتر از ماه گذشته"> 33% <i data-feather="chevron-up" class="w-4 h-4 mr-0.5"></i> </div>--}}
                                                <div class="report-box__indicator bg-theme-23 tooltip cursor-pointer" title="0% بالاتر از ماه گذشته"> 0% <i data-feather="chevron-up" class="w-4 h-4 mr-0.5"></i> </div>
                                            </div>
                                        </div>
                                        @php
                                            $order_items_count = \Modules\Shop\Entities\OrderItem::query()->get()->count()
                                        @endphp
                                        <div class="text-3xl font-bold leading-8 mt-6">{{ $order_items_count }}</div>
                                        <div class="text-base text-gray-600 mt-1">مورد فروش </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="credit-card" class="report-box__icon text-theme-22"></i>
                                            <div class="mr-auto">
                                                <div class="report-box__indicator bg-theme-23 tooltip cursor-pointer" title="0% بالاتر از ماه گذشته"> 0% <i data-feather="chevron-up" class="w-4 h-4 mr-0.5"></i> </div>
                                            </div>
                                        </div>
                                        @php
                                            $order_count = \Modules\Shop\Entities\Order::query()->get()->count()
                                        @endphp
                                        <div class="text-3xl font-bold leading-8 mt-6">{{ $order_count }}</div>
                                        <div class="text-base text-gray-600 mt-1">سفارش جدید</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="monitor" class="report-box__icon text-theme-23"></i>
                                            <div class="mr-auto">
                                                <div class="report-box__indicator bg-theme-23 tooltip cursor-pointer" title="0% بالاتر از ماه گذشته"> 0% <i data-feather="chevron-up" class="w-4 h-4 mr-0.5"></i> </div>
                                            </div>
                                        </div>
                                        @php
                                            $product_count = \Modules\Shop\Entities\Product::query()->get()->count()
                                        @endphp
                                        <div class="text-3xl font-bold leading-8 mt-6">{{ $product_count }}</div>
                                        <div class="text-base text-gray-600 mt-1">محصولات کلی</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('admin.user.statistics-visitor.index') }}" class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="user" class="report-box__icon text-theme-10"></i>
                                            <div class="mr-auto">
                                                <div class="report-box__indicator bg-theme-23 tooltip cursor-pointer" title="{{ $percentage }}% بالاتر از ماه گذشته"> {{ $percentage }}% <i data-feather="chevron-up" class="w-4 h-4 mr-0.5"></i> </div>
                                            </div>
                                        </div>
                                        <div class="text-3xl font-bold leading-8 mt-6">{{ $totalUniqueIPCount }}</div>
                                        <div class="text-base text-gray-600 mt-1">بازدیدکنندگان</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- END: General Report -->
                    <!-- BEGIN: Sales Report -->
                    <div class="col-span-12 lg:col-span-12 mt-8">
                        <div class="intro-y block sm:flex items-center h-10">
                            <h2 class="text-lg font-medium truncate ml-5">
                                گزارش فروش
                            </h2>
{{--                            <div class="sm:mr-auto mt-3 sm:mt-0 relative text-gray-700 dark:text-gray-300">--}}
{{--                                <i data-feather="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 mr-3 right-0"></i>--}}
{{--                                <input type="text" class="datepicker form-control sm:w-56 box pr-10">--}}
{{--                            </div>--}}
                        </div>
                        <div class="intro-y box p-5 mt-12 sm:mt-5">
                            <form >
                                <div class="flex flex-col xl:flex-row xl:items-center">

                                        <div class="dropdown xl:ml-auto mt-5 xl:mt-0">
                                            @php
                                                $cats = \Modules\Shop\Entities\ProductCatalogCategory::query()->pluck('title' , 'id')->toArray();
                                                $opt = [
                                                    'name'=>'category_id',
                                                    'title'=>'دسته بندی',
                                                    'type'=>'select_tag',
                                                    'options' => $cats
                                                ];
                                            @endphp
                                            {!! view('core::theme_admin.grid.filters.'.$opt['type'] , [  'options'=> $opt ] ) !!}
                                        </div>

                                        <div class="dropdown xl:ml-auto mt-5 xl:mt-0">
                                            @php
                                                $opt =[
                                                    'name'=>'good_id',
                                                    'title'=>'کد کالا',
                                                    'type'=>'text',
                                                ];
                                            @endphp
                                            {!! view('core::theme_admin.grid.filters.'.$opt['type'] , [  'options'=> $opt ] ) !!}
                                        </div>

                                        <div class="dropdown xl:ml-auto mt-5 xl:mt-0">
                                            <button type="submit" class="btn-primary btn">اعمال</button>
                                        </div>
                                </div>
                            </form>
                            <br><br><br>

                            <div class="report-chart">
                                <div class="mx-auto w-3/5 overflow-hidden">
                                    <canvas id="acquisitions"></canvas>
                                </div>
                            </div>


                            <br><br><br><br>
                            <h4>آخرین خطا ها</h4>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">ردیف</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">عنوان</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">دلیل</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">تاریخ</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">وضعیت</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap"> عملیات </th>
                                </tr>
                                </thead>
                                <tbody>
                                    @forelse($errors_log as $key => $er)
                                        <tr>
                                            <td class="border-b whitespace-nowrap">{{ ++ $key }}</td>
                                            <td class="border-b whitespace-nowrap"> {{ mb_substr($er->description , '0' , '50')  }} </td>
                                            <td class="border-b whitespace-nowrap"> {{ $er->reason }} </td>
                                            <td class="border-b whitespace-nowrap"> {{ jdate( $er->created_at )->format('Y-m-d H:i:s')  }} </td>
                                            <td class="border-b whitespace-nowrap"> {{ $er->resolved_at ? 'حل شده' : '-' }} </td>

                                            <td class="border-b whitespace-nowrap">
                                                @if($er->resolve_class && $er->resolve_method)
                                                    <a class="btn btn-warning btn-sm" href="{{ route('admin.core.errors.resolve' ,$er->id ) }}">تلاس مجدد</a>

                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">
                                                <p style="text-align: center">موردی یافت نشد</p>
                                            </td>

                                        </tr>

                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!-- END: Sales Report -->
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.3.0/chart.umd.js"></script>

    <script>
        //import Chart from 'chart.js/auto'
        (async function() {
            const data =  <?php echo json_encode($order_data) ; ?>


            // const data2 = [
            //     { year: 'فروردین', count: 30 },
            //     { year: 'اردیبهشت', count: 50 },
            //     { year: 'خرداد', count: 65 },
            //     { year: 'تیر', count: 65 },
            //     { year: 'مرداد', count: 200 },
            //     { year: 'شهریور', count: 50 },
            //     { year: 'مهر', count: 68 },
            //     { year: 'آبان', count: 78 },
            //     { year: 'آذر', count: 38 },
            //     { year: 'دی', count: 8 },
            //     { year: 'یهمن', count: 280 },
            //     { year: 'اسفند', count: 10 },
            // ];

            new Chart(
                document.getElementById('acquisitions'),
                {
                    type: 'line',
                    data: {
                        labels: data.map(row => row.year),
                        datasets: [
                            {
                            label: 'سفارشات',
                            data: data.map(row => row.count),
                            fill: false,
                            borderColor: 'rgb(204,128,17)',
                            tension: 0.1
                            },

                        ]
                    },
                }
            );
        })();

    </script>
@endsection
