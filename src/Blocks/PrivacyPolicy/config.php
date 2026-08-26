<?php

return [
    'name'            => 'be-privacy-policy',
    'title'           => '[Section v2] - Politique de confidentialité',
    'description'     => 'Politique de confidentialité',
    'category'        => 'lumina',
    'icon'            => 'shield',
    'keywords'        => ['privacy', 'rgpd', 'confidentialité'],
    'acf_block_version' => 3,
    'api_version'       => 3,
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