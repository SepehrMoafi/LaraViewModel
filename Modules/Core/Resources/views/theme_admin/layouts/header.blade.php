<!DOCTYPE html>

<html lang="en" class="light">
<!-- BEGIN: Head -->
<head>
    <meta charset="utf-8">
    <link href="{{asset('assets/theme_admin/dist/images/logo.png')}}" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> پنل مدیریت</title>
    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="{{asset('assets/theme_admin/dist/css/app.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/theme_admin/dist/css/select2.min.css')}}" />
    <!-- END: CSS Assets-->
    <style>
        .bg-danger.border.border-red-400.text-red-700.px-4.py-3.rounded.relative.mt-2 {
            background: #ff7a7a69;
        }
        .bg-danger.border.border-red-400.text-red-700.px-4.py-3.rounded.relative.mt-2>span {
            color: black !important;
        }
        .is-danger {
            background: #ffd5d566;
        }
        .is-success {
            background:rgb(214 255 192 / 64%);
        }
    </style>
    @yield('style')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<!-- END: Head -->
<body class="main">
<!-- BEGIN: Mobile Menu -->




