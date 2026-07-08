<?php

return [

    'name' => 'be-partners',

    'title' => '[Section v2] - Liste des Partners',

    'description' => 'Partners logos section',

    'category' => 'lumina',

    'icon' => 'groups',

    'keywords' => [
        'partners',
        'logos',
        'trusted'
    ],

    'mode' => 'preview',

    'render_template' => __DIR__ . '/render.php',

    'example' => [
        'attributes' => [
            'mode' => 'preview',
            'data' => [
                'is_preview' => true
            ]
        ]
    ],

    'lumina' => [
        'preview' => plugin_dir_url(__FILE__) . 'preview.png'
    ]

];