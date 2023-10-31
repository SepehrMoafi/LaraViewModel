@extends('core::theme_admin.layouts.app')

@section('content')
    <div class="bg-white shadow overflow-hidden sm:rounded-lg rounded-lg w-full">
        <div class="w-full">
            <table class="w-full border-separate border border-slate-500">
                <thead>
                <tr>
                    <th class="w-1/2 border border-slate-600 p-5">تعداد</th>
                    <th class="w-1/2 border border-slate-600 p-5">نوع</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="w-1/2 border border-slate-700 p-5">بازدید روزانه</td>
                    <td class="w-1/2 border border-slate-700 p-5">{{ $visitorsToday }}</td>
                </tr>
                <tr>
                    <td class="w-1/2 border border-slate-700 p-5">بازدید هفتگی</td>
                    <td class="w-1/2 border border-slate-700 p-5">{{ $visitorsThisWeek }}</td>
                </tr>
                <tr>
                    <td class="w-1/2 border border-slate-700 p-5">بازدید ماهانه</td>
                    <td class="w-1/2 border border-slate-700 p-5">{{ $visitorsThisMonth }}</td>
                </tr>
                <tr>
                    <td class="w-1/2 border border-slate-700 p-5">بازدید سالانه</td>
                    <td class="w-1/2 border border-slate-700 p-5">{{ $visitorsThisYear }}</td>
                </tr>
                <tr>
                    <td class="w-1/2 border border-slate-700 p-5">بازدید کل</td>
                    <td class="w-1/2 border border-slate-700 p-5">{{ $totalVisitors }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
