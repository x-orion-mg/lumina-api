<?php

use Lumina\ApiV2\Acf\ButtonFields;

if (!function_exists('acf_add_local_field_group')) {
    return;
}

$buttonFields = ButtonFields::group(
    'lumina_promo_banner_',
    'CTA'
);

acf_add_local_field_group([
    'key' => 'group_lumina_promo_banner',
    'title' => 'Lumina Promo Banner',

    'fields' => [
        [
            'key' => 'field_lumina_promo_banner_cards',
            'label' => 'Cards',
            'name' => 'cards',
            'type' => 'repeater',

            'instructions' => 'Configurez les deux banners promotionnels.',

            'required' => 1,

            'layout' => 'block',

            'min' => 2,
            'max' => 2,

            'button_label' => 'Ajouter une card',

            'sub_fields' => array_merge(
                [
                    [
                        'key' => 'field_lumina_promo_banner_card_subtitle',
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

                    [
                        'key' => 'field_lumina_promo_banner_card_title',
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

                    [
                        'key' => 'field_lumina_promo_banner_card_description',
                        'label' => 'Description',
                        'name' => 'description',
                        'type' => 'textarea',

                        'required' => 0,

                        'rows' => 4,

                        'new_lines' => 'br',
                    ],

                    [
                        'key' => 'field_lumina_promo_banner_card_image',
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
                ],
                $buttonFields
            ),
        ],
    ],

    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/lumina-promo-banner',
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