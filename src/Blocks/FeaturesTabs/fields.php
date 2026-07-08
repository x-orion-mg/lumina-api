<?php

acf_add_local_field_group([

    'key' => 'group_be_features_tabs',

    'title' => 'Block - Features Tabs',

    'fields' => [

        [
            'key' => 'field_be_features_tabs_badge',
            'label' => 'Badge',
            'name' => 'badge',
            'type' => 'text',
        ],

        [
            'key' => 'field_be_features_tabs_title',
            'label' => 'Title',
            'name' => 'title',
            'type' => 'textarea',
            'instructions' => 'Pour appliquer un effet de dégradé (gradient) à un texte, encadrez le mot ou l\'expression avec des crochets : [votre mot].',
            'rows' => 3,
            'new_lines' => 'br',
            'placeholder' => 'Exemple : Nous aidons les organisations à [bâtir la confiance].',
        ],

        [
            'key' => 'field_be_features_tabs_description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'textarea',
            'rows' => 4,
            'new_lines' => 'br',
        ],

        [
            'key' => 'field_be_features_tabs_items',
            'label' => 'Tabs',
            'name' => 'tabs',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Add Tab',
            'min' => 1,
            'sub_fields' => [

                [
                    'key' => 'field_be_features_tabs_item_icon',
                    'label' => 'Icon',
                    'name' => 'icon_lumina',
                    'type' => 'select',
                    'ui' => 1,
                    'allow_null' => 1,
                    'return_format' => 'value',
                ],

                [
                    'key' => 'field_be_features_tabs_item_label',
                    'label' => 'Tab Label',
                    'name' => 'label',
                    'type' => 'text',
                ],

                [
                    'key' => 'field_be_features_tabs_item_title',
                    'label' => 'Content Title',
                    'name' => 'title',
                    'type' => 'text',
                ],

                [
                    'key' => 'field_be_features_tabs_item_description',
                    'label' => 'Content Description',
                    'name' => 'content_description',
                    'type' => 'textarea',
                    'rows' => 5,
                    'new_lines' => 'br',
                ],

                [
                    'key' => 'field_be_features_tabs_item_features',
                    'label' => 'Features',
                    'name' => 'features',
                    'type' => 'repeater',
                    'layout' => 'table',
                    'button_label' => 'Add Feature',
                    'min' => 1,
                    'sub_fields' => [

                        [
                            'key' => 'field_be_features_tabs_item_feature_text',
                            'label' => 'Text',
                            'name' => 'text',
                            'type' => 'text',
                        ],

                    ],
                ],

                [
                    'key' => 'field_be_features_tabs_item_button',
                    'label' => 'Button',
                    'name' => 'button',
                    'type' => 'link',
                ],

                [
                    'key' => 'field_be_features_tabs_item_visual',
                    'label' => 'Visual',
                    'name' => 'visual',
                    'type' => 'image',
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'library' => 'all',
                ],

            ],
        ],

    ],

    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/be-features-tabs',
            ],
        ],
    ],

]);