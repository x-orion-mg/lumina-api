<?php

acf_add_local_field_group([

    'key' => 'group_be_human_first',

    'title' => 'Human First',

    'fields' => [

        [
            'key' => 'field_be_human_first_badge',
            'label' => 'Badge',
            'name' => 'badge',
            'type' => 'text',
        ],

        [
            'key' => 'field_be_human_first_title',
            'label' => 'Title',
            'name' => 'title',
            'type' => 'textarea',
            'instructions' => 'Pour appliquer un effet de dégradé (gradient) à un texte, encadrez le mot ou l\'expression avec des crochets : [votre mot].',
            'rows' => 3,
            'new_lines' => 'br',
            'placeholder' => 'Exemple : Nous aidons les organisations à [bâtir la confiance].',
        ],

        [
            'key' => 'field_be_human_first_description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'textarea',
        ],

        [
            'key' => 'field_be_human_first_features',
            'label' => 'Features',
            'name' => 'features',
            'type' => 'repeater',

            'layout' => 'block',

            'button_label' => 'Add Feature',

            'min' => 1,
            'max' => 3,

            'sub_fields' => [

                [
                    'key' => 'field_be_human_first_feature_icon',
                    'label' => 'Icon',
                    'name' => 'icon_lumina',
                    'type' => 'select',

                    'choices' => [
                        // icons list later
                    ],

                    'ui' => 1,

                    'return_format' => 'value',
                ],

                [
                    'key' => 'field_be_human_first_feature_title',
                    'label' => 'Title',
                    'name' => 'title',
                    'type' => 'text',
                ],

                [
                    'key' => 'field_be_human_first_feature_description',
                    'label' => 'Description',
                    'name' => 'description',
                    'type' => 'textarea',

                    'rows' => 3,
                ],

                [
                    'key' => 'field_be_human_first_feature_color',
                    'label' => 'Gradient Color',
                    'name' => 'gradient_color',
                    'type' => 'select',

                    'choices' => [
                        'orange' => 'Orange',
                        'purple' => 'Purple',
                        'blue' => 'Blue',
                    ],

                    'default_value' => 'purple',

                    'ui' => 1,

                    'return_format' => 'value',
                ],

            ],

        ],

        [
            'key' => 'field_be_human_first_bottom_items',
            'label' => 'Bottom Items',
            'name' => 'bottom_items',
            'type' => 'repeater',

            'layout' => 'table',

            'button_label' => 'Add Item',

            'min' => 1,
            'max' => 3,

            'sub_fields' => [

                [
                    'key' => 'field_be_human_first_bottom_item_icon',
                    'label' => 'Icon',
                    'name' => 'icon_lumina',
                    'type' => 'select',

                    'choices' => [
                        // icons list later
                    ],

                    'ui' => 1,

                    'return_format' => 'value',
                ],

                [
                    'key' => 'field_be_human_first_bottom_item_title',
                    'label' => 'Title',
                    'name' => 'title',
                    'type' => 'text',
                ],

            ],

        ],

    ],

    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/be-human-first',
            ],
        ],
    ],

]);