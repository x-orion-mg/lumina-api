<?php

if (!function_exists('acf_add_local_field_group')) {
    return;
}

acf_add_local_field_group([
    'key' => 'group_lumina_product_showcase',
    'title' => 'Lumina Product Showcase',

    'fields' => [

        /*
         * ==========================================================
         * TITRE
         * ==========================================================
         */
        [
            'key' => 'field_lumina_product_showcase_title',
            'label' => 'Titre',
            'name' => 'title',
            'type' => 'text',

            'instructions' => 'Titre principal de la section.',

            'required' => 1,

            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],

            'default_value' => '',
        ],

        /*
         * ==========================================================
         * TABS
         * ==========================================================
         */
        [
            'key' => 'field_lumina_product_showcase_tabs',
            'label' => 'Onglets',
            'name' => 'tabs',
            'type' => 'repeater',

            'instructions' => 'Ajoutez les onglets permettant de filtrer ou sélectionner les produits.',

            'required' => 1,

            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],

            'layout' => 'block',

            'min' => 1,
            'max' => 6,

            'button_label' => 'Ajouter un onglet',

            'sub_fields' => [

                /*
                 * --------------------------------------------------
                 * LABEL
                 * --------------------------------------------------
                 */
                [
                    'key' => 'field_lumina_product_showcase_tab_label',
                    'label' => 'Label',
                    'name' => 'label',
                    'type' => 'text',

                    'instructions' => 'Libellé affiché dans l’onglet.',

                    'required' => 1,

                    'wrapper' => [
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ],

                    'default_value' => '',
                ],

                /*
                 * --------------------------------------------------
                 * TYPE DE SOURCE
                 * --------------------------------------------------
                 */
                [
                    'key' => 'field_lumina_product_showcase_tab_source_type',
                    'label' => 'Source des produits',
                    'name' => 'source_type',
                    'type' => 'radio',

                    'instructions' => 'Choisissez si les produits sont récupérés depuis des catégories ou sélectionnés manuellement.',

                    'required' => 1,

                    'wrapper' => [
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ],

                    'choices' => [
                        'taxonomy' => 'Taxonomies',
                        'products' => 'Produits',
                    ],

                    'default_value' => 'taxonomy',

                    'layout' => 'horizontal',

                    'return_format' => 'value',
                ],

                /*
                 * --------------------------------------------------
                 * TAXONOMIES
                 * --------------------------------------------------
                 */
                [
                    'key' => 'field_lumina_product_showcase_tab_taxonomies',
                    'label' => 'Taxonomies',
                    'name' => 'taxonomies',
                    'type' => 'taxonomy',

                    'instructions' => 'Sélectionnez les catégories de produits à utiliser.',

                    'required' => 1,

                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],

                    'taxonomy' => 'product_cat',

                    'field_type' => 'checkbox',

                    'allow_null' => 0,

                    'add_term' => 0,

                    'save_terms' => 0,

                    'load_terms' => 0,

                    'return_format' => 'id',

                    'multiple' => 1,

                    'conditional_logic' => [
                        [
                            [
                                'field' => 'field_lumina_product_showcase_tab_source_type',
                                'operator' => '==',
                                'value' => 'taxonomy',
                            ],
                        ],
                    ],
                ],

                /*
                 * --------------------------------------------------
                 * PRODUITS
                 * --------------------------------------------------
                 */
                [
                    'key' => 'field_lumina_product_showcase_tab_products',
                    'label' => 'Produits',
                    'name' => 'products',
                    'type' => 'relationship',

                    'instructions' => 'Sélectionnez les produits à afficher dans cet onglet.',

                    'required' => 1,

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

                    'taxonomy' => '',

                    'filters' => [
                        'search',
                        'post_type',
                        'taxonomy',
                    ],

                    'return_format' => 'id',

                    'min' => 1,

                    'max' => 6,

                    'elements' => [
                        'featured_image',
                    ],

                    'conditional_logic' => [
                        [
                            [
                                'field' => 'field_lumina_product_showcase_tab_source_type',
                                'operator' => '==',
                                'value' => 'products',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    /*
     * ==========================================================
     * LOCATION
     * ==========================================================
     */
    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/lumina-product-showcase',
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