<?php

return [

    'name' => 'be-flexible-platform',

    'title' => '[Section v2] - Flexible Platform - Be Agile',

    'description' => 'Flexible platform slider section',

    'category' => 'lumina',

    'icon' => 'slides',

    'keywords' => [
        'platform',
        'slider',
        'cards',
        'services',
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

    // custom metadata
    'lumina' => [
        'preview' => plugin_dir_url(__FILE__) . 'preview.png',
        'version' => '1.0.0',
        'api' => true,
    ],

];