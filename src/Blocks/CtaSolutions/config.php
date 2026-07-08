<?php

return [

    'name'            => 'be-cta-solutions',
    'title'           => '[Section v2] - CTA Solutions',
    'description'     => 'Bannière CTA solutions',
    'category'        => 'lumina',
    'icon'            => 'cover-image',
    'keywords'        => ['cta', 'solutions', 'demo'],
    'mode'            => 'preview',
    'supports'        => [
        'align' => false,
        'mode'  => true,
    ],
    'render_template' => __DIR__ . '/render.php',
    'example'         => [
        'attributes' => [
            'mode' => 'preview',
            'data' => ['is_preview' => true],
        ],
    ],
    'lumina'       => [
        'preview' => plugin_dir_url(__FILE__) . 'preview.png',
        'version' => '1.0.0',
        'api'     => true,
    ],

];