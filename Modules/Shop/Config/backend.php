<?php

return [


    'item1_sub'=>[
        'title' => 'کاتالوگ محصولات',
        'route' => 'admin.shop.product-catalog.index',
        'icon' => 'list',
    ],

    'item3_sub'=>[
        'title' => 'محصولات',
        'route' => 'admin.shop.product.index',
        'icon' => 'list',
    ],
    'item9_sub'=>[
        'title' => 'محصولات با تعداد کم',
        'route' => 'admin.shop.product.lowCount',
        'icon' => 'list',
    ],

    'item2_sub'=>[
        'title' => ' دسته بندی',
        'route' => 'admin.shop.product-catalog-category.index',
        'icon' => 'list',
    ],

    'item4_sub'=>[
        'title' => ' برند ها ',
        'route' => 'admin.shop.brand.index',
        'icon' => 'list',
    ],

    'item7_sub'=>[
        'title' => 'گردونه شانس',
        'route' => 'admin.shop.luckyWheel.index',
        'icon' => 'list',
    ],
    'item10_sub'=>[
        'title' => 'برندگان گردونه شانس',
        'route' => 'admin.shop.luckyWheel.winners',
        'icon' => 'list',
    ],

    'item8_sub'=>[
        'title' => 'کالا های مرجوع شده',
        'route' => 'admin.shop.refund.index',
        'icon' => 'list',
    ],

    'item5_sub'=>[
        'title' => ' ویژگی ها ',
        'route' => 'admin.shop.attribute.index',
        'icon' => 'list',
    ],
    'item6_sub'=>[
        'title' => 'کامنت ها',
        'route' => 'admin.core.comments.index',
        'icon' => 'list',
    ],

    'discount'=>[
        'title' => 'مدیریت تخفیف ها',
        'icon' => 'list',
        'sub_items' => [
            'item1_sub'=>[
                'title' => 'لیست کد های تخفیف',
                'route' => 'admin.shop.copan.index',
                'icon' => 'list',
            ],
            'item2_sub'=>[
                'title' => 'افزودن کد تخفیف',
                'route' => 'admin.shop.copan.create',
                'icon' => 'feather',
            ],
        ],

    ],

    'payments'=>[
        'title' => 'پرداخت ها',
        'icon' => 'list',
        'sub_items' => [
            'item1_sub'=>[
                'title' => 'لیست پرداخت ها',
                'route' => 'admin.shop.payments.index',
                'icon' => 'list',
            ],
            'item2_sub'=>[
                'title' => 'فیش های بانکی',
                'route' => 'admin.shop.payments.index-rec',
                'icon' => 'list',
            ],
        ],

    ],

    'orders'=>[
        'title' => ' سفارشات ',
        'route' => 'admin.shop.orders.index',
        'icon' => 'list',
    ],


    'taraz-with-text'=>[
        'title' => 'آپدیت تراز',
        'route' => 'admin.shop.product.update-taraz-with-text',
        'icon' => 'list',
    ],

    'delivery'=>[
        'title' => 'راه های ارسال',
        'route' => 'admin.shop.delivery.index',
        'icon' => 'list',
    ],


];
