<?php

return [
    'name'        => 'lumina-testimonials',
    'title'       => 'Lumina - Testimonials',
    'description' => 'Affiche une sélection de témoignages.',
    'category'    => 'lumina',
    'icon'        => 'format-quote',

    'keywords' => [
        'lumina',
        'testimonials',
        'témoignages',
        'testimony',
    ],

    'mode' => 'preview',

    'supports' => [
        'align'  => false,
        'anchor' => true,
        'mode'   => true,
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
        'version' => '1.0.0',
        'api'     => true,
    ],
];