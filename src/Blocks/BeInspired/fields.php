<?php

acf_add_local_field_group([

    'key' => 'group_be_values',

    'title' => 'Block - Values',

    'fields' => [

        [
            'key' => 'field_be_values_tag',
            'label' => 'Tag',
            'name' => 'tag',
            'type' => 'text',
        ],

        [
            'key' => 'field_be_values_title',
            'label' => 'Title',
            'name' => 'title',
            'type' => 'textarea',
            'instructions' => 'Pour appliquer un effet de dégradé (gradient) à un texte, encadrez le mot ou l\'expression avec des crochets : [votre mot].',
            'rows' => 3,
            'new_lines' => 'br',
            'placeholder' => 'Exemple : Nous aidons les organisations à [bâtir la confiance].',
        ],

        [
            'key' => 'field_be_values_description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'textarea',
            'rows' => 4,
            'new_lines' => 'br',
        ],

        [
            'key' => 'field_be_values_button',
            'label' => 'Button',
            'name' => 'button',
            'type' => 'link',
        ],

        [
            'key' => 'field_be_values_items',
            'label' => 'Cards',
            'name' => 'items',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Add card',
            'min' => 1,
            'max' => 4,
            'sub_fields' => [

                [
                    'key' => 'field_be_values_items_icon',
                    'label' => 'Icon',
                    'name' => 'icon_lumina',
                    'type' => 'select',
                    'ui' => 1,
                    'allow_null' => 1,
                    'return_format' => 'value',
                ],

                [
                    'key' => 'field_be_values_items_title',
                    'label' => 'Title',
                    'name' => 'title',
                    'type' => 'text',
                ],

                [
                    'key' => 'field_be_values_items_color',
                    'label' => 'Color',
                    'name' => 'color',
                    'type' => 'select',
                    'choices' => [
                        'green' => 'Green',
                        'orange' => 'Orange',
                        'pink' => 'Pink',
                        'purple' => 'Purple',
                    ],
                    'default_value' => 'purple',
                    'ui' => 1,
                    'return_format' => 'value',
                ],

            ],
        ],

    ],

    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/be-values',
            ],
        ],
    ],

]);