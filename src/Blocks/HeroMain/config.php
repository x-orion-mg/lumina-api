<?php

return [

    'name' => 'be-hero-main',

    'title' => 'Hero Main',

    'description' => 'Main hero section for landing pages',

    'category' => 'lumina',

    'icon' => 'cover-image',

    'keywords' => [
        'hero',
        'banner',
        'landing'
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
                'is_preview' => true
            ]
        ]
    ],

    // custom metadata
    'lumina' => [
        'preview' => plugin_dir_url(__FILE__) . 'preview.png',
        'version' => '1.0.0',
        'api' => true
    ]

];
