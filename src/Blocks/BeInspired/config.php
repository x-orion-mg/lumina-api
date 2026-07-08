<?php

return [

    'name' => 'be-values',

    'title' => '[Section v2] - Values - Be Inspired',

    'description' => 'Values - Be Inspired section',

    'category' => 'lumina',

    'icon' => 'screenoptions',

    'keywords' => [
        'values',
        'commitment',
        'cards',
        'Be Inspired'
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