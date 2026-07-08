<?php

return [

    'name' => 'be-cta-banner',

    'title' => '[Section v2] - CTA Banner',

    'description' => 'Get started - CTA gradient banner',

    'category' => 'lumina',

    'icon' => 'megaphone',

    'keywords' => [
        'cta',
        'banner',
        'call to action',
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