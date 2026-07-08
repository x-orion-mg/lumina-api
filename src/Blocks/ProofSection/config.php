<?php

return [

    'name' => 'be-proof-section',

    'title' => '[Section v2] - Proof Section',

    'description' => 'Section preuves sociales / CTA',

    'category' => 'lumina',

    'icon' => 'cover-image',

    'keywords' => [
        'proof',
        'stats',
        'cta',
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