<?php

acf_add_local_field_group([

    'key' => 'group_be_compliance_targets',

    'title' => 'Compliance Targets',

    'fields' => [

        [
            'key' => 'field_be_compliance_badge',
            'label' => 'Badge',
            'name' => 'badge',
            'type' => 'text',
        ],

        [
            'key' => 'field_be_compliance_title',
            'label' => 'Title',
            'name' => 'title',
            'type' => 'textarea',
            'instructions' => 'Pour appliquer un effet de dégradé (gradient) à un texte, encadrez le mot ou l\'expression avec des crochets : [votre mot].',
            'rows' => 3,
            'new_lines' => 'br',
            'placeholder' => 'Exemple : Nous aidons les organisations à [bâtir la confiance].',
        ],

        [
            'key' => 'field_be_compliance_description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'textarea',
        ],

        [
            'key' => 'field_be_compliance_cards',
            'label' => 'Cards',
            'name' => 'cards',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Add Card',
            'min' => 0,
            'max' => 3,
            'sub_fields' => [

                [
                    'key' => 'field_be_compliance_card_icon',
                    'label' => 'Icon',
                    'name' => 'icon_lumina',
                    'type' => 'select',
                    'ui' => 1,
                    'allow_null' => 1,
                    'return_format' => 'value',
                ],

                [
                    'key' => 'field_be_compliance_card_title',
                    'label' => 'Title',
                    'name' => 'title',
                    'type' => 'text',
                ],

                [
                    'key' => 'field_be_compliance_card_description',
                    'label' => 'Description',
                    'name' => 'description',
                    'type' => 'textarea',
                    'rows' => 5,
                ],

                [
                    'key' => 'field_be_compliance_card_link',
                    'label' => 'Link',
                    'name' => 'link',
                    'type' => 'link',
                ],

            ],

        ],

    ],

    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/be-compliance-targets',
            ],
        ],
    ],

]);