<?php

return [
    'name'            => 'be-contact-form-section',
    'title'           => '[Section v2] - Contact Form Section',
    'description'     => 'Section contact avec formulaire HubSpot intégré',
    'category'        => 'lumina',
    'icon'            => 'email',
    'keywords'        => ['contact', 'formulaire', 'hubspot'],
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