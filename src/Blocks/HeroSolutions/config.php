<?php

return [
    'name'            => 'be-hero-solutions',
    'title'           => '[Section v2] - Hero Solutions',
    'description'     => 'Hero principal pour les pages solutions',
    'category'        => 'lumina',
    'icon'            => 'cover-image',
    'keywords'        => ['hero', 'entreprise', 'banner','solutions'],
    'mode'            => 'preview',
    'supports'        => [
        'align' => false,
        'mode'  => true,
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
    'lumina'       => [
        'preview' => plugin_dir_url(__FILE__) . 'preview.png',
        'version' => '1.0.0',
        'api'     => true,
    ],
];