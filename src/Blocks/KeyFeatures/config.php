<?php

return [
    'name'            => 'be-key-features',
    'title'           => '[Section v2] - Key Features Solutions',
    'description'     => 'Liste des fonctionnalités clés',
    'category'        => 'lumina',
    'icon'            => 'list-view',
    'keywords'        => ['features', 'fonctionnalités', 'liste', 'Solutions'],
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