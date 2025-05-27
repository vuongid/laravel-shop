<?php

return [
    'template' => [
        'status' => [
            '1'       => ['name' => 'Kích hoạt', 'class' => 'btn-success'],
            '2'       => ['name' => 'Chưa kích hoạt', 'class' => 'btn-secondary'],
        ],
        'search' => [
            'all'         => ['name' => 'Search by All'],
            'title'       => ['name' => 'Search by Title'],
        ],
    ],

    'format' => [
        'long_time'  => 'H:m:s d/m/Y',
        'short_time' => 'd/m/Y',
    ],

    'config' => [
        'search' => [
            'default'  => ['all'],
            'slider'   => ['all', 'title'],
        ],
    ]
];
