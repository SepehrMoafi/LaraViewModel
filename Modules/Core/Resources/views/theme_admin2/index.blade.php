@extends('core::theme_admin.layouts.app')

@section('content')

    <!--**********************************
        Content body start
    ***********************************-->
    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">
            <div class="form-head mb-4">
                <h2 class="text-black font-w600 mb-0">داشبرد</h2>
            </div>
            <div class="row">
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="media align-items-center">
                                <div class="media-body">
                                    <h2 class="fs-38 text-black font-w600">582</h2>
                                    <span class="fs-18">تعداد کاربران</span>
                                </div>
                                <span class="p-3 border mr-3 rounded-circle">
										<i style="
											padding: 0 6px;
											font-size: 34px;
											color: #858585;

											" class="fa fa-user"></i>
									</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="media align-items-center">
                                <div class="media-body">
                                    <h2 class="fs-38 text-black font-w600">236</h2>
                                    <span class="fs-18">جمع پرداخت های 30 روز اخیر</span>
                                </div>
                                <span class="p-3 border mr-3 rounded-circle">
										<i style="
											padding: 0 6px;
											font-size: 34px;
											color: #858585;

											" class="fa fa-credit-card"></i>
									</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="media align-items-center">
                                <div class="media-body">
                                    <h2 class="fs-38 text-black font-w600">582</h2>
                                    <span class="fs-18">تعداد سفارشات</span>
                                </div>
                                <span class="p-3 border mr-3 rounded-circle">
										<svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path
                                                d="M26.9165 1.41669H7.08317C5.58028 1.41669 4.13894 2.01371 3.07623 3.07642C2.01353 4.13912 1.4165 5.58046 1.4165 7.08335V17C1.4165 17.3757 1.56576 17.7361 1.83144 18.0018C2.09711 18.2674 2.45745 18.4167 2.83317 18.4167H9.9165V31.1667C9.91583 31.4376 9.99289 31.7031 10.1385 31.9316C10.2842 32.1601 10.4923 32.342 10.7382 32.4559C10.9847 32.5693 11.2585 32.6096 11.5273 32.5719C11.796 32.5343 12.0482 32.4202 12.254 32.2434L16.2915 28.7867L20.329 32.2434C20.5856 32.4628 20.9122 32.5834 21.2498 32.5834C21.5875 32.5834 21.9141 32.4628 22.1707 32.2434L26.2082 28.7867L30.2457 32.2434C30.5023 32.4628 30.8289 32.5834 31.1665 32.5834C31.3715 32.5819 31.574 32.5385 31.7615 32.4559C32.0074 32.342 32.2155 32.1601 32.3612 31.9316C32.5068 31.7031 32.5838 31.4376 32.5832 31.1667V7.08335C32.5832 5.58046 31.9862 4.13912 30.9234 3.07642C29.8607 2.01371 28.4194 1.41669 26.9165 1.41669ZM4.24984 15.5834V7.08335C4.24984 6.33191 4.54835 5.61124 5.0797 5.07988C5.61105 4.54853 6.33172 4.25002 7.08317 4.25002C7.83462 4.25002 8.55529 4.54853 9.08664 5.07988C9.61799 5.61124 9.9165 6.33191 9.9165 7.08335V15.5834H4.24984ZM29.7498 28.0925L27.129 25.84C26.8724 25.6205 26.5458 25.4999 26.2082 25.4999C25.8705 25.4999 25.5439 25.6205 25.2873 25.84L21.2498 29.2967L17.2123 25.84C16.9557 25.6205 16.6292 25.4999 16.2915 25.4999C15.9538 25.4999 15.6273 25.6205 15.3707 25.84L12.7498 28.0925V7.08335C12.7481 6.08812 12.4842 5.1109 11.9848 4.25002H26.9165C27.668 4.25002 28.3886 4.54853 28.92 5.07988C29.4513 5.61124 29.7498 6.33191 29.7498 7.08335V28.0925ZM26.9165 8.50002C26.9165 8.87574 26.7673 9.23608 26.5016 9.50175C26.2359 9.76743 25.8756 9.91669 25.4998 9.91669H16.9998C16.6241 9.91669 16.2638 9.76743 15.9981 9.50175C15.7324 9.23608 15.5832 8.87574 15.5832 8.50002C15.5832 8.1243 15.7324 7.76396 15.9981 7.49829C16.2638 7.23261 16.6241 7.08335 16.9998 7.08335H25.4998C25.8756 7.08335 26.2359 7.23261 26.5016 7.49829C26.7673 7.76396 26.9165 8.1243 26.9165 8.50002ZM26.9165 14.1667C26.9165 14.5424 26.7673 14.9027 26.5016 15.1684C26.2359 15.4341 25.8756 15.5834 25.4998 15.5834H16.9998C16.6241 15.5834 16.2638 15.4341 15.9981 15.1684C15.7324 14.9027 15.5832 14.5424 15.5832 14.1667C15.5832 13.791 15.7324 13.4306 15.9981 13.165C16.2638 12.8993 16.6241 12.75 16.9998 12.75H25.4998C25.8756 12.75 26.2359 12.8993 26.5016 13.165C26.7673 13.4306 26.9165 13.791 26.9165 14.1667ZM26.9165 19.8334C26.9165 20.2091 26.7673 20.5694 26.5016 20.8351C26.2359 21.1008 25.8756 21.25 25.4998 21.25H16.9998C16.6241 21.25 16.2638 21.1008 15.9981 20.8351C15.7324 20.5694 15.5832 20.2091 15.5832 19.8334C15.5832 19.4576 15.7324 19.0973 15.9981 18.8316C16.2638 18.5659 16.6241 18.4167 16.9998 18.4167H25.4998C25.8756 18.4167 26.2359 18.5659 26.5016 18.8316C26.7673 19.0973 26.9165 19.4576 26.9165 19.8334Z"
                                                fill="#858585" />
										</svg>
									</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="d-sm-flex  d-block align-items-center mb-4">
                        <div class="ml-auto">
                            <h4 class="fs-20 text-black">آخرین سفارشات ثبت شده</h4>
                            <span class="fs-12"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive table-hover fs-14">
                        <table class="table display mb-4 dataTablesCard " id="example5">
                            <thead>
                            <tr>
                                <th>شناسه فاکتور</th>
                                <th>تاریخ</th>
                                <th>نام</th>
                                <th>مبلغ</th>
                                <th>وضعیت</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><span class="text-black font-w500">#123412451</span></td>
                                <td><span class="text-black text-nowrap">1401-11-05</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h6 class="fs-16 text-black font-w600 mb-0 text-nowrap"> علی صالح </h6>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="text-black">2,500,000 تومان</span></td>
                                <td><a href="javascript:void(0)" class="btn btn-success btn-sm btn-rounded">تکمیل شده</a></td>
                            </tr>

                            <tr>
                                <td><span class="text-black font-w500">#123412451</span></td>
                                <td><span class="text-black text-nowrap">1401-11-05</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h6 class="fs-16 text-black font-w600 mb-0  text-nowrap"> مجید احمدی </h6>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="text-black">2,500,000 تومان</span></td>
                                <td><a href="javascript:void(0)" class="btn btn-success btn-sm btn-rounded">تکمیل شده</a></td>

                            </tr>

                            <tr>
                                <td><span class="text-black font-w500">#123412451</span></td>
                                <td><span class="text-black text-nowrap">1401-11-05</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h6 class="fs-16 text-black font-w600 mb-0 text-nowrap"> الیا عباسی </h6>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="text-black">2,500,000 تومان</span></td>
                                <td><a href="javascript:void(0)" class="btn btn-danger btn-sm  btn-rounded">در انتظار پرداخت</a></td>

                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--**********************************
        Content body end
    ***********************************-->


@endsection
