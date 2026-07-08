<?php

return [

    'name' => 'be-features-tabs',

    'title' => '[Section v2] - Features Tabs',

    'description' => 'Section tabs fonctionnalités',

    'category' => 'lumina',

    'icon' => 'screenoptions',

    'keywords' => [
        'tabs',
        'features',
        'custom',
    ],

    'mode' => 'preview',

    'supports' => [
        'align' => false,
        'mode' => true,
    ],

    'render_template' => __DIR__ . '/render.php',

    'example' => [
        'attributes' => [
            'mode' => 'preview',
            'data' => [
                'is_preview' => true,
            ],
        ],
    ],

    'lumina' => [
        'preview' => plugin_dir_url(__FILE__) . 'preview.png',
        'version' => '1.0.0',
        'api' => true,
    ],

];