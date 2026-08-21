<?php

return [
    'name'            => 'lumina-hero',
    'title'           => 'Lumina - Hero',
    'description'     => 'Hero principal avec slider de produits et jusqu’à 3 cards promotionnelles.',
    'category'        => 'lumina',
    'icon'            => 'slides',
    'keywords'        => [
        'lumina',
        'hero',
        'slider',
        'produits',
        'promotion',
    ],
    'mode'            => 'preview',

    'supports'        => [
        'align'  => false,
        'anchor' => true,
        'mode'   => true,
    ],

    'render_template' => __DIR__ . '/render.php',

    'example'         => [
        'attributes' => [
            'mode' => 'preview',
            'data' => [
                'is_preview' => true,
            ],
        ],
    ],

    'lumina'          => [
        'version' => '1.0.0',
        'api'     => true,
    ],
];