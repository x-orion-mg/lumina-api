<?php

return [
    'name'            => 'be-rebranding-story-hero',
    'title'           => '[Section v2] - Rebranding Story Hero',
    'description'     => 'Hero histoire du rebranding',
    'category'        => 'lumina',
    'icon'            => 'format-image',
    'keywords'        => ['rebranding', 'story', 'hero'],
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