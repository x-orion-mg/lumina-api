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