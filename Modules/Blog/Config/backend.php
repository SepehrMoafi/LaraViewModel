<?php

return [

    'posts'=>[
        'title' => 'مقالات',
        'icon' => 'pen-tool',
        'sub_items' => [
            'item1_sub'=>[
                'title' => 'لیست مقالات',
                'route' => 'admin.blog.posts.index',
                'icon' => 'list',
            ],
            'cat'=>[
                'title' => 'لیست دسته بندی ها',
                'route' => 'admin.blog.post-category.index',
                'icon' => 'list',
            ],
        ],
    ],



];
