<?php

return [

    'name'            => 'be-why-choose-solutions',
    'title'           => '[Section v2] - Why Choose Solutions',
    'description'     => 'Section avantages avec cartes',
    'category'        => 'lumina',
    'icon'            => 'cover-image',
    'keywords'        => ['why choose', 'solutions', 'cards'],
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