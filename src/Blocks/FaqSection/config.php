<?php

return [
    'name'            => 'be-faq-section',
    'title'           => '[Section v2] - FAQ Section',
    'description'     => 'Section FAQ avec accordéon',
    'category'        => 'lumina',
    'icon'            => 'editor-help',
    'keywords'        => ['faq', 'questions', 'accordion'],
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