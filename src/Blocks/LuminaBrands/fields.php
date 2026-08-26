<?php

if (!function_exists('acf_add_local_field_group')) {
    return;
}

acf_add_local_field_group([
    'key' => 'group_lumina_brands',
    'title' => 'Lumina Brands',

    'fields' => [
        
        [
            'key' => 'field_lumina_brands_title',
            'label' => 'Titre',
            'name' => 'title',
            'type' => 'text',

            'required' => 1,

            'default_value' => '',
        ],
        
        [
            'key' => 'field_lumina_brands_brands',
            'label' => 'Marques',
            'name' => 'brands',
            'type' => 'relationship',

            'instructions' => 'Si aucune marque n’est sélectionnée, les marques les plus récentes seront affichées automatiquement.',

            'required' => 0,

            'post_type' => [
                'testimony',
            ],

            'post_status' => [
                'publish',
            ],

            'filters' => [
                'search',
            ],

            'return_format' => 'id',

        ],
    ],
    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/lumina-brands',
            ],
        ],
    ],

    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
]);