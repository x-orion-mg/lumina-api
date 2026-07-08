<?php

acf_add_local_field_group([

    'key' => 'group_be_proof_section',

    'title' => 'Block - Proof Section',

    'fields' => [

        [
            'key' => 'field_be_proof_badge',
            'label' => 'Badge',
            'name' => 'badge',
            'type' => 'text',
        ],

        [
            'key' => 'field_be_proof_title',
            'label' => 'Title',
            'name' => 'title',
            'type' => 'textarea',
            'rows' => 2,
            'new_lines' => 'br',
        ],

        [
            'key' => 'field_be_proof_description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'textarea',
            'rows' => 4,
            'new_lines' => 'br',
        ],

        [
            'key' => 'field_be_proof_button',
            'label' => 'Button',
            'name' => 'button',
            'type' => 'link',
        ],
        [
            'key' => 'field_be_proof_stats',
            'label' => 'Stats',
            'name' => 'stats',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Add Stat',
            'min' => 1,
            'max' => 3,
            'sub_fields' => [
                [
                    'key' => 'field_be_proof_stats_icon',
                    'label' => 'Icon',
                    'name' => 'icon_lumina',
                    'type' => 'select',
                    'ui' => 1,
                    'allow_null' => 1,
                    'return_format' => 'value',
                ],

                [
                    'key' => 'field_be_proof_stats_value',
                    'label' => 'Value',
                    'name' => 'value',
                    'type' => 'text',
                ],

                [
                    'key' => 'field_be_proof_stats_suffix',
                    'label' => 'Suffix',
                    'name' => 'suffix',
                    'type' => 'text',
                ],

                [
                    'key' => 'field_be_proof_stats_description',
                    'label' => 'Description',
                    'name' => 'description',
                    'type' => 'textarea',
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
                'value' => 'acf/be-proof-section',
            ],
        ],
    ],

]);