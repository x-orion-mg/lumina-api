<?php

acf_add_local_field_group([

    'key' => 'group_be_cta_banner',

    'title' => 'Block - CTA Banner',

    'fields' => [

        [
            'key' => 'field_be_cta_banner_tag',
            'label' => 'Tag',
            'name' => 'tag',
            'type' => 'text',
        ],

        [
            'key' => 'field_be_cta_banner_title',
            'label' => 'Title',
            'name' => 'title',
            'type' => 'textarea',
            'rows' => 3,
            'new_lines' => 'br',
        ],

        [
            'key' => 'field_be_cta_banner_description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'textarea',
            'rows' => 3,
            'new_lines' => 'br',
        ],

        [
            'key' => 'field_be_cta_banner_primary_button',
            'label' => 'Primary Button',
            'name' => 'primary_button',
            'type' => 'link',
        ],

        [
            'key' => 'field_be_cta_banner_secondary_button',
            'label' => 'Secondary Button',
            'name' => 'secondary_button',
            'type' => 'link',
        ],

    ],

    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/be-cta-banner',
            ],
        ],
    ],

]);