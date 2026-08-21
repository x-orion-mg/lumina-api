<?php

use Lumina\ApiV2\Acf\ButtonFields;

if (!function_exists('acf_add_local_field_group')) {
    return;
}

/**
 * Champs du bouton des slides.
 */
$slideButtonFields = ButtonFields::group(
    'lumina_hero_slide_'
);

/**
 * Champs du bouton des cards.
 */
$cardButtonFields = ButtonFields::group(
    'lumina_hero_card_'
);

acf_add_local_field_group([
    'key' => 'group_lumina_hero',
    'title' => 'Lumina Hero',

    'fields' => [

        /*
         * ==========================================================
         * HERO SLIDER
         * ==========================================================
         */
        [
            'key' => 'field_lumina_hero_slider',
            'label' => 'Hero principal',
            'name' => 'hero_slider',
            'type' => 'repeater',
            'instructions' => 'Ajoutez les slides du hero principal.',
            'required' => 0,
            'conditional_logic' => 0,

            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],

            'layout' => 'block',

            'min' => 1,
            'max' => 5,

            'button_label' => 'Ajouter une slide',

            'sub_fields' => array_merge(
                [
                    [
                        'key' => 'field_lumina_hero_slide_eyebrow',
                        'label' => 'Surtitre',
                        'name' => 'eyebrow',
                        'type' => 'text',
                        'instructions' => 'Petit texte affiché au-dessus du titre.',
                        'required' => 0,

                        'wrapper' => [
                            'width' => '50',
                            'class' => '',
                            'id' => '',
                        ],

                        'default_value' => '',
                    ],

                    [
                        'key' => 'field_lumina_hero_slide_title',
                        'label' => 'Titre',
                        'name' => 'title',
                        'type' => 'textarea',
                        'instructions' => 'Titre principal de la slide.',
                        'required' => 1,

                        'wrapper' => [
                            'width' => '50',
                            'class' => '',
                            'id' => '',
                        ],

                        'default_value' => '',
                        'rows' => 3,
                        'new_lines' => 'br',
                    ],

                    [
                        'key' => 'field_lumina_hero_slide_description',
                        'label' => 'Description',
                        'name' => 'description',
                        'type' => 'textarea',
                        'instructions' => 'Description ou texte complémentaire.',
                        'required' => 0,

                        'wrapper' => [
                            'width' => '50',
                            'class' => '',
                            'id' => '',
                        ],

                        'default_value' => '',
                        'rows' => 3,
                        'new_lines' => 'br',
                    ],

                    [
                        'key' => 'field_lumina_hero_slide_price',
                        'label' => 'Prix',
                        'name' => 'price',
                        'type' => 'text',
                        'instructions' => 'Texte libre permettant de contrôler exactement l’affichage du prix.',
                        'required' => 0,

                        'wrapper' => [
                            'width' => '50',
                            'class' => '',
                            'id' => '',
                        ],

                        'default_value' => '',
                    ],

                    [
                        'key' => 'field_lumina_hero_slide_image',
                        'label' => 'Image',
                        'name' => 'image',
                        'type' => 'image',
                        'instructions' => 'Image principale de la slide.',
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
                $slideButtonFields
            ),
        ],

        /*
         * ==========================================================
         * CARDS
         * ==========================================================
         */
        [
            'key' => 'field_lumina_hero_cards',
            'label' => 'Cards promotionnelles',
            'name' => 'cards',
            'type' => 'repeater',

            'instructions' => 'Ajoutez jusqu’à 3 cards promotionnelles.',

            'required' => 0,

            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],

            'layout' => 'block',

            'min' => 0,
            'max' => 3,

            'button_label' => 'Ajouter une card',

            'sub_fields' => array_merge(
                [
                    [
                        'key' => 'field_lumina_hero_card_eyebrow',
                        'label' => 'Surtitre',
                        'name' => 'eyebrow',
                        'type' => 'text',

                        'wrapper' => [
                            'width' => '50',
                            'class' => '',
                            'id' => '',
                        ],

                        'default_value' => '',
                    ],

                    [
                        'key' => 'field_lumina_hero_card_title',
                        'label' => 'Titre',
                        'name' => 'title',
                        'type' => 'textarea',

                        'wrapper' => [
                            'width' => '50',
                            'class' => '',
                            'id' => '',
                        ],

                        'default_value' => '',
                        'rows' => 3,
                        'new_lines' => 'br',
                    ],

                    [
                        'key' => 'field_lumina_hero_card_description',
                        'label' => 'Description',
                        'name' => 'description',
                        'type' => 'textarea',

                        'wrapper' => [
                            'width' => '50',
                            'class' => '',
                            'id' => '',
                        ],

                        'default_value' => '',
                        'rows' => 3,
                        'new_lines' => 'br',
                    ],

                    [
                        'key' => 'field_lumina_hero_card_image',
                        'label' => 'Image',
                        'name' => 'image',
                        'type' => 'image',

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
                $cardButtonFields
            ),
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
                'value' => 'acf/lumina-hero',
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