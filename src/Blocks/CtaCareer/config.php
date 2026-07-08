<?php

return [

    'name' => 'be-cta-career',

    'title' => 'CTA Career',

    'description' => 'Section CTA recrutement',

    'category' => 'lumina',

    'icon' => 'megaphone',

    'keywords' => [
        'cta',
        'career',
        'recruitment',
    ],

    'mode' => 'preview',

    'supports' => [
        'align' => false,
        'mode' => true,
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
        'preview' => plugin_dir_url(__FILE__) . 'preview.png',
        'version' => '1.0.0',
        'api' => true,
    ],

];