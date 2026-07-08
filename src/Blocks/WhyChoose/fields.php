<?php

acf_add_local_field_group([

    'key' => 'group_be_why_choose',

    'title' => 'Block - Why Choose',

    'fields' => [

        [
            'key' => 'field_be_why_choose_badge',
            'label' => 'Badge',
            'name' => 'badge',
            'type' => 'text',
        ],

        [
            'key' => 'field_be_why_choose_title',
            'label' => 'Title',
            'name' => 'title',
            'type' => 'textarea',
            'instructions' => 'Pour appliquer un effet de dégradé (gradient) à un texte, encadrez le mot ou l\'expression avec des crochets : [votre mot].',
            'rows' => 3,
            'new_lines' => 'br',
            'placeholder' => 'Exemple : Nous aidons les organisations à [bâtir la confiance].',
        ],

        [
            'key' => 'field_be_why_choose_description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'textarea',
            'rows' => 4,
            'new_lines' => 'br',
        ],

        [
            'key' => 'field_be_why_choose_cards',
            'label' => 'Cards',
            'name' => 'cards',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Add Card',
            'min' => 1,
            'max' => 3,
            'sub_fields' => [

                [
                    'key' => 'field_be_why_choose_card_icon',
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
                    'key' => 'field_be_why_choose_card_title',
                    'label' => 'Title',
                    'name' => 'title',
                    'type' => 'text',
                ],

                [
                    'key' => 'field_be_why_choose_card_description',
                    'label' => 'Description',
                    'name' => 'card_description',
                    'type' => 'textarea',
                    'rows' => 6,
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
                'value' => 'acf/be-why-choose',
            ],
        ],
    ],

]);