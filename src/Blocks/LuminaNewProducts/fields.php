<?php

if (!function_exists('acf_add_local_field_group')) {
    return;
}

acf_add_local_field_group([
    'key' => 'group_lumina_new_products',
    'title' => 'Lumina New Products',

    'fields' => [
        [
            'key' => 'field_lumina_new_products_title',
            'label' => 'Titre',
            'name' => 'title',
            'type' => 'text',

            'required' => 0,

            'default_value' => '',
        ],
        [
            'key' => 'field_lumina_new_products_products',
            'label' => 'Produits',
            'name' => 'products',
            'type' => 'relationship',

            'instructions' => 'Sélectionnez jusqu’à 3 produits. Si aucun produit n’est sélectionné, les produits les plus récents seront récupérés automatiquement.',

            'required' => 0,

            'post_type' => [
                'product',
            ],

            'post_status' => [
                'publish',
            ],

            'filters' => [
                'search',
                'taxonomy',
            ],

            'return_format' => 'id',

            'min' => 0,

            'max' => 8,

            'elements' => [
                'featured_image',
            ],
        ],
    ],
    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/lumina-new-products',
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