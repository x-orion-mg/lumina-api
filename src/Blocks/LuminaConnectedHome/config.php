<?php

return [
    'name'        => 'lumina-connected-home',
    'title'       => 'Lumina - Connected Home',
    'description' => 'Section maison connectée avec cartes de contenu.',
    'category'    => 'lumina',
    'icon'        => 'admin-home',

    'keywords' => [
        'lumina',
        'connected',
        'home',
        'maison',
        'smart home',
    ],

    'mode' => 'preview',

    'supports' => [
        'align'  => false,
        'anchor' => true,
        'mode'   => true,
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
        'version' => '1.0.0',
        'api'     => true,
    ],
];