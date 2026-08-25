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