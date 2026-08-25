<?php

return [
    'name'        => 'lumina-product-showcase',
    'title'       => 'Lumina - Product Showcase',
    'description' => 'Affiche une sélection de produits organisée par onglets.',
    'category'    => 'lumina',
    'icon'        => 'screenoptions',
    'keywords'    => [
        'lumina',
        'produits',
        'product',
        'showcase',
        'onglets',
        'tabs',
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
        'preview' => plugin_dir_url(__FILE__) . 'preview.png',
        'version' => '1.0.0',
        'api'     => true,
    ],
];