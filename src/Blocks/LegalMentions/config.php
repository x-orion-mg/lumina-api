<?php

return [
    'name'            => 'be-legal-mentions',
    'title'           => '[Section v2] - Mentions légales',
    'description'     => 'Section Mentions légales avec contenu répétable',
    'category'        => 'lumina',
    'icon'            => 'media-document',
    'keywords'        => ['mentions', 'légal', 'juridique'],
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