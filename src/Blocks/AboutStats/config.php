<?php

return [

    'name' => 'be-about-stats',

    'title' => 'About - Stats',

    'description' => 'Section présentation avec statistiques',

    'category' => 'lumina',

    'icon' => 'cover-image',

    'keywords' => [
        'about',
        'stats',
        'trust',
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