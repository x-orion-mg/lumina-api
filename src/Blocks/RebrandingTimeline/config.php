<?php

return [
    'name'            => 'be-rebranding-timeline',
    'title'           => '[Section v2] - Rebranding Timeline',
    'description'     => 'Timeline de l’évolution de Lumina',
    'category'        => 'lumina',
    'icon'            => 'backup',
    'keywords'        => ['timeline', 'history', 'rebranding'],
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