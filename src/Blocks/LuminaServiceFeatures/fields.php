<?php

if (!function_exists('acf_add_local_field_group')) {
    return;
}

acf_add_local_field_group([
    'key' => 'group_lumina_service_features',
    'title' => 'Lumina Service Features',

    'fields' => [
        [
            'key' => 'field_lumina_service_features',
            'label' => 'Features',
            'name' => 'features',
            'type' => 'repeater',

            'instructions' => 'Ajoutez les services ou avantages à afficher.',

            'required' => 1,

            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],

            'layout' => 'block',

            'min' => 1,
            'max' => 6,

            'button_label' => 'Ajouter une feature',

            'sub_fields' => [
                [
                    'key' => 'field_lumina_service_feature_icon',
                    'label' => 'Icône',
                    'name' => 'icon_lumina',
                    'type' => 'select',

                    'instructions' => 'Sélectionnez une icône Lumina.',
                    'ui' => 1,
                    'allow_null' => 1,
                    'return_format' => 'value',
                    'required' => 1,
                ],

                [
                    'key' => 'field_lumina_service_feature_title',
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
                    'key' => 'field_lumina_service_feature_description',
                    'label' => 'Description',
                    'name' => 'description',
                    'type' => 'textarea',

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
            ],
        ],
    ],

    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/lumina-service-features',
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