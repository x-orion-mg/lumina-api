<?php

return [
    'name'        => 'lumina-product-category',
    'title'       => 'Lumina - Product Category',
    'description' => 'Affiche une catégorie de produits avec un produit mis en avant.',
    'category'    => 'lumina',
    'icon'        => 'products',

    'keywords' => [
        'lumina',
        'produits',
        'product',
        'category',
        'catégorie',
        'woocommerce',
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