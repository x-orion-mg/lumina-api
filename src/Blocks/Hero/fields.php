<?php
acf_add_local_field_group([
    'key' => 'group_be_hero',
    'title' => 'Hero Section',
    'fields' => [
        [
            'key' => 'field_title',
            'label' => 'Title',
            'name' => 'title',
            'type' => 'text',
        ],
        [
            'key' => 'field_image',
            'label' => 'Image',
            'name' => 'image',
            'type' => 'image',
        ]
    ],
    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/be-hero'
            ]
        ]
    ]
]);