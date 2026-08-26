<?php

return [
    'name' => 'lumina-service-features',
    'title' => 'Lumina - Service Features',
    'description' => 'Liste de services ou avantages Lumina.',
    'category' => 'lumina',
    'icon' => 'star-filled',
    'keywords' => [
        'lumina',
        'services',
        'features',
        'avantages',
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
        'preview' => plugin_dir_url(__FILE__) . 'preview.png',
        'version' => '1.0.0',
        'api'     => true,
    ],
];