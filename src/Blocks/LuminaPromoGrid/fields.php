<?php

use Lumina\ApiV2\Acf\ButtonFields;

if (!function_exists('acf_add_local_field_group')) {
    return;
}

/**
 * Champs du CTA des promotions.
 */
$promoButtonFields = ButtonFields::group(
    'lumina_promo_grid_',
    'CTA'
);

acf_add_local_field_group([
    'key' => 'group_lumina_promo_grid',
    'title' => 'Lumina Promo Grid',

    'fields' => [
        [
            'key' => 'field_lumina_promo_grid_promotions',
            'label' => 'Promotions',
            'name' => 'promotions',
            'type' => 'repeater',

            'instructions' => 'Ajoutez jusqu’à 3 produits promotionnels.',

            'required' => 0,

            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],

            'layout' => 'block',

            'min' => 1,
            'max' => 3,

            'button_label' => 'Ajouter une promotion',

            'sub_fields' => array_merge(
                [
                    [
                        'key' => 'field_lumina_promo_grid_product',
                        'label' => 'Produit',
                        'name' => 'product',
                        'type' => 'relationship',

                        'instructions' => 'Sélectionnez le produit concerné par la promotion.',

                        'required' => 1,

                        'wrapper' => [
                            'width' => '50',
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

                        'min' => 1,
                        'max' => 1,

                        'elements' => [
                            'featured_image',
                        ],
                    ],
                    [
                        'key' => 'field_lumina_promo_grid_subtitle',
                        'label' => 'Sous-titre',
                        'name' => 'subtitle',
                        'type' => 'textarea',

                        'instructions' => 'Petit texte affiché au-dessus du titre.',

                        'required' => 0,

                        'wrapper' => [
                            'width' => '50',
                            'class' => '',
                            'id' => '',
                        ],

                        'default_value' => '',

                        'rows' => 2,

                        'new_lines' => 'br',
                    ],
                    [
                        'key' => 'field_lumina_promo_grid_title',
                        'label' => 'Titre',
                        'name' => 'title',
                        'type' => 'textarea',

                        'instructions' => 'Titre principal de la promotion.',

                        'required' => 1,

                        'wrapper' => [
                            'width' => '50',
                            'class' => '',
                            'id' => '',
                        ],

                        'default_value' => '',

                        'rows' => 4,

                        'new_lines' => 'br',
                    ],
                    [
                        'key' => 'field_lumina_promo_grid_image',
                        'label' => 'Image',
                        'name' => 'image',
                        'type' => 'image',

                        'instructions' => 'Visuel utilisé pour la promotion. Il peut être différent de l’image principale du produit.',

                        'required' => 1,

                        'wrapper' => [
                            'width' => '50',
                            'class' => '',
                            'id' => '',
                        ],

                        'return_format' => 'array',

                        'library' => 'all',

                        'preview_size' => 'medium',
                    ],
                ],
                $promoButtonFields
            ),
        ],
    ],
    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/lumina-promo-grid',
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