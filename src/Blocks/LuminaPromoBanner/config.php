<?php

return [
    'name'        => 'lumina-promo-banner',
    'title'       => 'Lumina - Promo Banner',
    'description' => 'Deux banners promotionnels.',
    'category'    => 'lumina',
    'icon'        => 'format-image',

    'keywords' => [
        'lumina',
        'promo',
        'promotion',
        'banner',
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