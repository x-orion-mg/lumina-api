<?php

use Lumina\ApiV2\Acf\ButtonFields;

if (!function_exists('acf_add_local_field_group')) {
    return;
}

$buttonFields = ButtonFields::group(
    'lumina_connected_home_',
    'CTA'
);

acf_add_local_field_group([
    'key' => 'group_lumina_connected_home',
    'title' => 'Lumina Connected Home',

    'fields' => [

        /*
         * ==========================================================
         * SOUS-TITRE
         * ==========================================================
         */
        [
            'key' => 'field_lumina_connected_home_subtitle',
            'label' => 'Sous-titre',
            'name' => 'subtitle',
            'type' => 'text',

            'required' => 0,

            'wrapper' => [
                'width' => '50',
                'class' => '',
                'id' => '',
            ],

            'default_value' => '',
        ],

        /*
         * ==========================================================
         * TITRE
         * ==========================================================
         */
        [
            'key' => 'field_lumina_connected_home_title',
            'label' => 'Titre',
            'name' => 'title',
            'type' => 'textarea',

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

        /*
         * ==========================================================
         * CTA
         * ==========================================================
         */
        ...$buttonFields,

        /*
         * ==========================================================
         * CARDS
         * ==========================================================
         */
        [
            'key' => 'field_lumina_connected_home_cards',
            'label' => 'Cards',
            'name' => 'cards',
            'type' => 'repeater',

            'instructions' => 'Ajoutez les cartes de la section maison connectée.',

            'required' => 1,

            'layout' => 'block',

            'min' => 1,
            'max' => 3,

            'button_label' => 'Ajouter une carte',

            'sub_fields' => [
                [
                    'key' => 'field_lumina_connected_home_card_image',
                    'label' => 'Image',
                    'name' => 'image',
                    'type' => 'image',

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

                [
                    'key' => 'field_lumina_connected_home_card_title',
                    'label' => 'Titre',
                    'name' => 'title',
                    'type' => 'text',

                    'required' => 1,

                    'wrapper' => [
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ],

                    'default_value' => '',
                ],

                [
                    'key' => 'field_lumina_connected_home_card_description',
                    'label' => 'Description',
                    'name' => 'description',
                    'type' => 'textarea',

                    'required' => 1,

                    'rows' => 4,

                    'new_lines' => 'br',
                ],
            ],
        ],
    ],

    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/lumina-connected-home',
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