<?php

acf_add_local_field_group([

    'key' => 'group_be_hero_main',

    'title' => 'Hero Main',

    'fields' => [

        [
            'key' => 'field_badge_text',
            'label' => 'Badge Text',
            'name' => 'badge_text',
            'type' => 'text',
        ],

        [
            'key' => 'field_title',
            'label' => 'Title',
            'name' => 'title',
            'type' => 'textarea',
            'instructions' => 'Pour appliquer un effet de dégradé (gradient) à un texte, encadrez le mot ou l\'expression avec des crochets : [votre mot].',
            'rows' => 3,
            'new_lines' => 'br',
            'placeholder' => 'Exemple : Nous aidons les organisations à [bâtir la confiance].',
        ],

        [
            'key' => 'field_description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'textarea',
        ],

        [
            'key' => 'field_primary_button',
            'label' => 'Primary Button',
            'name' => 'primary_button',
            'type' => 'link',
        ],

        [
            'key' => 'field_secondary_button',
            'label' => 'Secondary Button',
            'name' => 'secondary_button',
            'type' => 'link',
        ],

        [
            'key' => 'field_stats',
            'label' => 'Stats',
            'name' => 'stats',
            'type' => 'repeater',

            'sub_fields' => [

                [
                    'key' => 'field_stat_value',
                    'label' => 'Value',
                    'name' => 'value',
                    'type' => 'text',
                ],

                [
                    'key' => 'field_stat_label',
                    'label' => 'Label',
                    'name' => 'label',
                    'type' => 'text',
                ]

            ]

        ],

        [
            'key' => 'field_hero_mockup',
            'label' => 'Hero Mockup',
            'name' => 'hero_mockup',
            'type' => 'image',
            'return_format' => 'array',
        ],

        [
            'key' => 'field_notification_text',
            'label' => 'Notification Text',
            'name' => 'notification_text',
            'type' => 'text',
        ],

        [
            'key' => 'field_notification_subtitle',
            'label' => 'Notification Subtitle',
            'name' => 'notification_subtitle',
            'type' => 'text',
        ],

        [
            'key' => 'field_resolution_rate',
            'label' => 'Resolution Rate',
            'name' => 'resolution_rate',
            'type' => 'text',
        ],

    ],

    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/be-hero-main',
            ],
        ],
    ],

]);