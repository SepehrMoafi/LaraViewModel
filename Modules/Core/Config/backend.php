<?php

return [

    'item1'=>[
        'title' => 'تنظیمات',
        'icon' => 'settings',
        'sub_items' => [
            'item1_sub'=>[
                'title' => 'تنظیمات اصلی',
                'route' => 'admin.core.setting.main-setting',
                'icon' => 'sliders',
            ],
        ],
    ],

    'item2'=>[
        'title' => 'اسلایدر',
        'icon' => 'image',
        'route' => 'admin.core.sliders.index',
    ],

    'item3'=>[
        'title' => 'مديریت صفحات',
        'icon' => 'settings',
        'route' => 'admin.core.blocks.index',
    ],

    'item4'=>[
        'title' => 'مديریت فهرست',
        'icon' => 'settings',
        'route' => 'admin.core.menus.index',
    ],


    'item5'=>[
        'title' => 'مديریت فایل',
        'icon' => 'settings',
        'route' => 'admin.core.file-manager-f',
    ],


//    'item4'=>[
//        'title' => 'شهر و استان',
//        'icon' => 'state',
//        'route' => 'admin.core.state.index',
//    ],
];
