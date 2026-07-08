<?php

acf_add_local_field_group([

    'key' => 'group_be_flexible_platform',

    'title' => 'Flexible Platform',

    'fields' => [

        [
            'key' => 'field_be_flexible_platform_badge',
            'label' => 'Badge',
            'name' => 'badge',
            'type' => 'text',
        ],

        [
            'key' => 'field_be_flexible_platform_title',
            'label' => 'Title',
            'name' => 'title',
            'type' => 'textarea',
            'instructions' => 'Pour appliquer un effet de dégradé (gradient) à un texte, encadrez le mot ou l\'expression avec des crochets : [votre mot].',
            'rows' => 3,
            'new_lines' => 'br',
            'placeholder' => 'Exemple : Nous aidons les organisations à [bâtir la confiance].',
        ],

        [
            'key' => 'field_be_flexible_platform_description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'textarea',
        ],

        [
            'key' => 'field_be_flexible_platform_cards',
            'label' => 'Cards',
            'name' => 'cards',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Add Card',
            'min' => 1,
            'sub_fields' => [

                [
                    'key' => 'field_be_flexible_platform_card_icon',
                    'label' => 'Icon',
                    'name' => 'icon_lumina',
                    'type' => 'select',
                    'choices' => [
                        // icons list here later
                    ],
                    'ui' => 1,
                    'allow_null' => 1,
                    'return_format' => 'value',
                ],

                [
                    'key' => 'field_be_flexible_platform_card_title',
                    'label' => 'Title',
                    'name' => 'title',
                    'type' => 'text',
                ],

                [
                    'key' => 'field_be_flexible_platform_card_description',
                    'label' => 'Description',
                    'name' => 'description',
                    'type' => 'textarea',
                    'rows' => 4,
                ],
            ],

        ],

        [
            'key' => 'field_be_flexible_platform_slider_hint',
            'label' => 'Slider Hint',
            'name' => 'slider_hint',
            'type' => 'text',

            'default_value' => 'Faites glisser ou utilisez les flèches pour naviguer',
        ],

    ],

    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/be-flexible-platform',
            ],
        ],
    ],

]);