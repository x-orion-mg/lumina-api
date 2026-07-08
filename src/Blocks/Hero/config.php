<?php

return [
    'name'            => 'be-hero',
    'title'           => 'Hero Section',
    'category'        => 'lumina',
    'icon'            => 'cover-image',
    'mode'            => 'preview',
    'keywords'        => ['hero', 'banner', 'lumina'],
    'render_template' => __DIR__ . '/render.php',
    'supports'        => [
        'align'  => true,
        'anchor' => true,
        'mode'   => true,
    ],
    'example'         => [
        'attributes' => [
            'mode' => 'preview',
            'data' => [
                'is_preview' => true,
            ],
        ],
    ],
];
