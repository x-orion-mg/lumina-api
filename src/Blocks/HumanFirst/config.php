<?php

return [

    'name' => 'be-human-first',

    'title' => '[Section v2] - Human First',

    'description' => 'Human first section',

    'category' => 'lumina',

    'icon' => 'groups',

    'keywords' => [
        'human',
        'features',
        'benefits',
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

    // custom metadata
    'lumina' => [
        'preview' => plugin_dir_url(__FILE__) . 'preview.png',
        'version' => '1.0.0',
        'api' => true,
    ],

];