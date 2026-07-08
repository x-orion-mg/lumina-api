<?php

return [

    'name' => 'be-why-choose',

    'title' => '[Section v2] - Why Choose - Be Different',

    'description' => 'Section pourquoi choisir Lumina',

    'category' => 'lumina',

    'icon' => 'columns',

    'keywords' => [
        'services',
        'cards',
        'benefits',
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