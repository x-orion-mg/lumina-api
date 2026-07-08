<?php

return [

    'name' => 'be-testimonials',

    'title' => '[Section v2] - Testimonials - #Be Impactful',

    'description' => 'Testimonials section',

    'category' => 'lumina',

    'icon' => 'format-quote',

    'keywords' => [
        'testimonials',
        'clients',
        'reviews',
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