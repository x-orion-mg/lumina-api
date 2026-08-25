<?php

if (!function_exists('acf_add_local_field_group')) {
    return;
}

acf_add_local_field_group([
    'key' => 'group_lumina_product_promotions',
    'title' => 'Lumina Product Promotions',

    'fields' => [
        [
            'key' => 'field_lumina_product_promotions_title',
            'label' => 'Titre',
            'name' => 'title',
            'type' => 'text',

            'required' => 1,

            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],

            'default_value' => '',
        ],
        [
            'key' => 'field_lumina_product_promotions_products',
            'label' => 'Produits',
            'name' => 'products',
            'type' => 'relationship',

            'instructions' => 'Sélectionnez jusqu’à 3 produits. Si aucun produit n’est sélectionné, les produits actuellement en promotion seront récupérés automatiquement.',

            'required' => 0,

            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],

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

            'max' => 3,

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
                'value' => 'acf/lumina-product-promotions',
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