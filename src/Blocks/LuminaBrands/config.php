<?php

return [
    'name'        => 'lumina-brands',
    'title'       => 'Lumina - Brands',
    'description' => 'Affiche une sélection de marques.',
    'category'    => 'lumina',
    'icon'        => 'share-alt',

    'keywords' => [
        'lumina',
        'brands',
        'marques',
    ],

    'acf_block_version' => 3,
    'api_version'       => 3,

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