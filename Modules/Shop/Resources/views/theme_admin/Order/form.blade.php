@extends('core::theme_admin.layouts.app')

@section('content')
    <div class="content">
        <form @if(! $view_model->getModelData('id') ) action="{{ route('admin.shop.orders.store') }}" method="POST"
              @else action="{{ route('admin.shop.orders.update' , $view_model->getModelData('id') ) }}"
              method="POST" @endif  enctype="multipart/form-data">
            @csrf
            @if( $view_model->getModelData('id') ) @method('PUT') @endif

            <div class="intro-y box overflow-hidden mt-5">

                <div class="px-5 sm:px-16 py-10 sm:py-20">
                    <div>
                        <div class="flex gap-4 items-center mb-3">
                            <p class="text-xs text-gray-400">  {{ jdate($order->created_at)->format('Y-m-d') }} </p>
                            <p class="text-xs text-gray-400"> کد سفارش :<span>223{{ $order->id }}</span></p>
                            <p class="text-xs text-gray-400">مبلغ: <span> {{ $order->amount }} </span> تومان </p>
                            <p class="text-xs text-gray-400">مبلغ قابل پرداخت: <span> {{ $order->payable_amount }} </span> تومان </p>
                            <p class="text-xs text-gray-400">وضعیت سفارش: <span> {!! $order->status_text_badage !!} </span> </p>
                        </div>
                    </div>
                    <p class="text-lg font-medium text-theme-17 dark:text-gray-300 mt-2">  </p>
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">توضیحات</th>
                                <th class="border-b-2 dark:border-dark-5 text-left whitespace-nowrap">تعداد</th>
                                <th class="border-b-2 dark:border-dark-5 text-left whitespace-nowrap">قیمت</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($order->order_items->where('item_type' , \Modules\Shop\Entities\Product::class) as $order_item)
                                    <tr>
                                        <td class="border-b dark:border-dark-5">
                                            <div class="font-medium whitespace-nowrap">{{ $order_item->item_obj->catalog->title }} </div>
                                            <div class="text-gray-600 text-sm mt-0.5 whitespace-nowrap">{{ @ $order_item->item_obj->catalog->brand->title}}</div>
                                        </td>
                                        <td class="text-left border-b dark:border-dark-5 w-32">{{ $order_item->qty }}</td>
                                        <td class="text-left border-b dark:border-dark-5 w-32">{{$order_item->total_amount }} تومان</td>
                                    </tr>
                                @endforeach

                                @foreach($order->order_items->where('item_type' ,  \Modules\Shop\Entities\DeliveryType::class ) as $order_item)
                                    <tr>
                                        <td class="border-b dark:border-dark-5">
                                            <div class="font-medium whitespace-nowrap">{{ $order_item->item_obj->title }} </div>
                                        </td>
                                        <td class="text-left border-b dark:border-dark-5 w-32">{{ $order_item->qty }}</td>
                                        <td class="text-left border-b dark:border-dark-5 w-32">{{$order_item->total_amount }} تومان</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="px-5 sm:px-20 pb-10 sm:pb-20 flex flex-col-reverse sm:flex-row">
                    <div class="text-center sm:text-right mt-10 sm:mt-0">
                        <div class="text-base text-gray-600"> وضعیت کنونی سفارش :  {!! $order->status_text_badage !!}</div>
                    </div>
                    <div class="text-center sm:text-right sm:mr-auto">
                        <form action="">
                            <label for="">وضعیت جدید</label>
                            <select class="form-control mb-3" name="status">
                                @foreach(\Modules\Shop\Entities\Order::STATUS as $st_id => $st)
                                    <option @if($order->status == $st_id ) selected @endif value="{{$st_id}}">{{ $st }}</option>
                                @endforeach
                            </select>

                            <label>کد پیگیری پست</label>
                            <input name="params[track_code]" id="crud-form-3" type="text" class="form-control w-full {{$errors->has('params.track_code') ? 'is-danger' :''}}" value="{{old( 'params.track_code' , $view_model->getModelDataJson('paramsJson.track_code') )}}" placeholder="">

                            @error('params.track_code')
                                <div class="alert-danger-soft">{{ $message }}</div>
                            @enderror

                            <button class="btn btn-success mt-3">ثبت</button>
                        </form>

                    </div>
                </div>

            </div>

        </form>
    </div>


@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/theme_admin/dist/jdate/persian-datepicker.min.css') }}"/>
@endsection


@section('scripts')
{{--    <script src="{{ asset('assets/theme_admin/dist/ckeditor5/ckeditor.js') }}"></script>--}}

    <script src="{{ asset('assets/theme_admin/dist/jdate/persian-date.min.js') }}"></script>
    <script src="{{ asset('assets/theme_admin/dist/jdate/persian-datepicker.min.js') }}"></script>

    <script>
        $(document).ready(function() {


            $(".example1").pDatepicker(
                {
                    initialValueType: 'gregorian',
                    format: 'YYYY-MM-DD',
                    calendar:{
                        persian: {
                            locale: 'en'
                        }
                    }

                }
            );

            $('.js-select-tag').select2({
                'tags': true,
            });

            $('.js-select-2').select2();
        });
    </script>

@endsection
