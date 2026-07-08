<?php

acf_add_local_field_group([
    'key' => 'group_demo_request',
    'title' => 'Block - Demo Request',
    'fields' => [

        [
            'key' => 'field_demo_request_tag',
            'label' => 'Tag',
            'name' => 'tag',
            'type' => 'text',
            'placeholder' => '#Demander une démo',
        ],

        [
            'key' => 'field_demo_request_title',
            'label' => 'Titre',
            'name' => 'title',
            'type' => 'textarea',
            'instructions' => 'Pour appliquer un effet de dégradé (gradient) à un texte, encadrez le mot ou l\'expression avec des crochets : [votre mot].',
            'rows' => 3,
            'new_lines' => 'br',
            'placeholder' => 'Pourquoi choisir [Lumina] ?',
        ],

        [
            'key' => 'field_demo_request_description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'textarea',
            'rows' => 4,
            'new_lines' => 'br',
        ],

        [
            'key' => 'field_demo_request_benefits',
            'label' => 'Cartes avantages',
            'name' => 'benefits',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Ajouter une carte',
            'min' => 1,
            'sub_fields' => [

                [
                    'key' => 'field_demo_request_benefit_icon',
                    'label' => 'Icône',
                    'name' => 'icon_lumina',
                    'type' => 'select',
                    'ui' => 1,
                    'allow_null' => 1,
                    'return_format' => 'value',
                ],

                [
                    'key' => 'field_demo_request_benefit_text',
                    'label' => 'Texte',
                    'name' => 'text',
                    'type' => 'textarea',
                    'rows' => 3,
                    'new_lines' => 'br',
                ],

            ],
        ],

        [
            'key' => 'field_demo_request_form_title',
            'label' => 'Titre formulaire',
            'name' => 'form_title',
            'type' => 'text',
            'default_value' => 'Demander une démo',
        ],

        [
            'key' => 'field_demo_request_form_description',
            'label' => 'Description formulaire',
            'name' => 'form_description',
            'type' => 'text',
        ],

        [
            'key' => 'field_demo_request_form',
            'label' => 'Formulaire HubSpot',
            'name' => 'form',
            'type' => 'relationship',
            'post_type' => [
                'contact-form',
            ],
            'filters' => [
                'search',
            ],
            'max' => 1,
            'return_format' => 'id',
        ],
        [
            'key' => 'field_demo_request_footer',
            'label' => 'Condition d\'utilisation',
            'name' => 'description_conditions',
            'type' => 'wysiwyg',
            'rows' => 3,
        ]

    ],
    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/demo-request',
            ],
        ],
    ],
]);