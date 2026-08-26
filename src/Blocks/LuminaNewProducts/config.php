<?php

return [
    'name'        => 'lumina-new-products',
    'title'       => 'Lumina - New Products',
    'description' => 'Affiche les nouveaux produits avec possibilité de sélection manuelle.',
    'category'    => 'lumina',
    'icon'        => 'products',

    'keywords' => [
        'lumina',
        'produits',
        'product',
        'nouveautés',
        'new',
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