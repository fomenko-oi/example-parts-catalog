<?php

return [
    'driver' => 'gd_laravel',
    'enabled' => true,

    'drivers' => [
        'text' => [
            'value' => strtoupper('SITENAME.COM'),
            'size' => 70,
            'x' => 30,
            'y' => 200
        ],
        'gd_laravel' => [
            'position' => [
                'x' => 5,
                'y' => 5,
                'position' => 'bottom-right',
            ],
            'watermark' => storage_path('app/watermark.png'),
            'width' => 130,
            'height' => 90,
        ]
    ]
];
