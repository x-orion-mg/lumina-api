<?php

return [

    'name' => 'demo-request',

    'title' => 'Demo Request',

    'description' => 'Section demande de démo avec avantages et formulaire',

    'category' => 'lumina',

    'icon' => 'cover-image',

    'keywords' => [
        'demo',
        'contact',
        'hubspot',
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