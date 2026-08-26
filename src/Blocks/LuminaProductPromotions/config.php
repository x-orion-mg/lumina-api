<?php

return [
    'name'        => 'lumina-product-promotions',
    'title'       => 'Lumina - Product Promotions',
    'description' => 'Affiche les produits en promotion avec possibilité de sélection manuelle.',
    'category'    => 'lumina',
    'icon'        => 'tag',

    'keywords' => [
        'lumina',
        'produits',
        'product',
        'promotion',
        'promotions',
        'woocommerce',
        'sale',
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