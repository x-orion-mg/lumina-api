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