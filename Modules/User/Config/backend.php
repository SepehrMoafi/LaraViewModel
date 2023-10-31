
<?php

return [

    'users'=>[
        'title' => 'کاربران',
        'icon' => 'users',
        'sub_items' => [
            'item1_sub'=>[
                'title' => 'لیست کاربران',
                'route' => 'admin.user.users.index',
                'icon' => 'list',
            ],
            'item2_sub'=>[
                'title' => 'لیست کاربران حقوقی',
                'route' => 'admin.user.users-company.index',
                'icon' => 'list',
            ],
            'item3_sub'=>[
                'title' => 'کاربران خبرنامه',
                'route' => 'admin.user.subscribe-users.index',
                'icon' => 'list',
            ],
            'item4_sub'=>[
                'title' => 'ارسال پیام',
                'route' => 'admin.user.send-sms.index',
                'icon' => 'list',
            ],
        ],
    ],

    'users_tickets'=>[
        'title' => 'پیام ها',
        'icon' => 'users',
        'sub_items' => [
            'item1_sub'=>[
                'title' => 'لیست پیام ها',
                'route' => 'admin.user.tickets.index',
                'icon' => 'list',
            ],
        ],
    ],
    'departments'=>[
        'title' => 'دپارتمان ها',
        'icon' => 'users',
        'sub_items' => [
            'item1_sub'=>[
                'title' => 'لیست دپارتمان ها',
                'route' => 'admin.user.departments.index',
                'icon' => 'list',
            ],
        ],
    ],


];
