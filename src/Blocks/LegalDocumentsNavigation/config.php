<?php

return [
    'name'            => 'be-legal-documents-navigation',
    'title'           => '[Section v2] - Legal Documents Navigation',
    'description'     => 'Navigation et aide pour les pages légales',
    'category'        => 'lumina',
    'icon'            => 'index-card',
    'keywords'        => ['privacy', 'legal', 'navigation'],
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