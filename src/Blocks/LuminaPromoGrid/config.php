<?php

return [
    'name'        => 'lumina-promo-grid',
    'title'       => 'Lumina - Promo Grid',
    'description' => 'Grille de produits promotionnels.',
    'category'    => 'lumina',
    'icon'        => 'grid-view',

    'keywords' => [
        'lumina',
        'promotion',
        'promo',
        'produits',
        'product',
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