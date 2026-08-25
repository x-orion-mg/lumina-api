<?php

use Lumina\ApiV2\Acf\ButtonFields;

if (!function_exists('acf_add_local_field_group')) {
    return;
}

$featuredButtonFields = ButtonFields::group(
    'lumina_product_category_featured_',
    'CTA'
);

acf_add_local_field_group([
    'key' => 'group_lumina_product_category',
    'title' => 'Lumina Product Category',

    'fields' => [

        [
            'key' => 'field_lumina_product_category_title',
            'label' => 'Titre',
            'name' => 'title',
            'type' => 'text',
            'required' => 1,
        ],
        [
            'key' => 'field_lumina_product_category_source_type',
            'label' => 'Source des produits',
            'name' => 'source_type',
            'type' => 'radio',

            'required' => 1,

            'choices' => [
                'taxonomy' => 'Taxonomie',
                'products' => 'Produits',
            ],

            'default_value' => 'taxonomy',

            'layout' => 'horizontal',

            'return_format' => 'value',
        ],
        [
            'key' => 'field_lumina_product_category_taxonomy',
            'label' => 'Catégorie de produits',
            'name' => 'taxonomy',
            'type' => 'taxonomy',

            'instructions' => 'Sélectionnez la catégorie WooCommerce.',

            'required' => 1,

            'taxonomy' => 'product_cat',

            'field_type' => 'select',

            'allow_null' => 0,

            'add_term' => 0,

            'save_terms' => 0,

            'load_terms' => 0,

            'return_format' => 'id',

            'multiple' => 0,

            'conditional_logic' => [
                [
                    [
                        'field' => 'field_lumina_product_category_source_type',
                        'operator' => '==',
                        'value' => 'taxonomy',
                    ],
                ],
            ],
        ],
        [
            'key' => 'field_lumina_product_category_products',
            'label' => 'Produits',
            'name' => 'products',
            'type' => 'relationship',

            'instructions' => 'Sélectionnez les produits à afficher.',

            'required' => 1,

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

            'min' => 1,

            'max' => 4,

            'elements' => [
                'featured_image',
            ],

            'conditional_logic' => [
                [
                    [
                        'field' => 'field_lumina_product_category_source_type',
                        'operator' => '==',
                        'value' => 'products',
                    ],
                ],
            ],
        ],
        [
            'key' => 'field_lumina_product_category_featured',
            'label' => 'Produit mis en avant',
            'name' => 'featured',
            'type' => 'group',

            'required' => 1,

            'layout' => 'block',

            'sub_fields' => array_merge(
                [
                    [
                        'key' => 'field_lumina_product_category_featured_product',
                        'label' => 'Produit',
                        'name' => 'product',
                        'type' => 'relationship',

                        'required' => 1,

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

                        'min' => 1,
                        'max' => 1,

                        'elements' => [
                            'featured_image',
                        ],
                    ],

                    [
                        'key' => 'field_lumina_product_category_featured_subtitle',
                        'label' => 'Sous-titre',
                        'name' => 'subtitle',
                        'type' => 'textarea',

                        'required' => 0,

                        'rows' => 2,

                        'new_lines' => 'br',
                    ],

                    [
                        'key' => 'field_lumina_product_category_featured_title',
                        'label' => 'Titre',
                        'name' => 'title',
                        'type' => 'textarea',

                        'required' => 1,

                        'rows' => 4,

                        'new_lines' => 'br',
                    ],

                    [
                        'key' => 'field_lumina_product_category_featured_image',
                        'label' => 'Image',
                        'name' => 'image',
                        'type' => 'image',

                        'required' => 1,

                        'return_format' => 'array',

                        'library' => 'all',

                        'preview_size' => 'medium',
                    ],
                ],
                $featuredButtonFields
            ),
        ],
    ],

    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/lumina-product-category',
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