<?php

return [
    'name'        => 'lumina-documentation',
    'title'       => 'Lumina - Documentation',
    'description' => 'Section de documentation avec articles sélectionnés ou récupérés automatiquement.',
    'category'    => 'lumina',
    'icon'        => 'media-document',

    'keywords' => [
        'lumina',
        'documentation',
        'articles',
        'blog',
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