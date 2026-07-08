<?php

return [

    'name' => 'be-compliance-targets',

    'title' => '[Section v2] - Compliance Targets - #Be Confident',

    'description' => 'Compliance targets section',

    'category' => 'lumina',

    'icon' => 'shield',

    'keywords' => [
        'compliance',
        'targets',
        'cards',
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

    // custom metadata
    'lumina' => [
        'preview' => plugin_dir_url(__FILE__) . 'preview.png',
        'version' => '1.0.0',
        'api' => true,
    ],

];