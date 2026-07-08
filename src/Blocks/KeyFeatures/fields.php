<?php

acf_add_local_field_group([
    'key'      => 'group_be_key_features',
    'title'    => 'Block - Key Features',
    'fields'   => [
        [
            'key'           => 'field_be_key_features_title',
            'label'         => 'Titre',
            'name'          => 'title',
            'type'          => 'textarea',
            'instructions'  => 'Pour appliquer un effet de dégradé (gradient) à un texte, encadrez le mot ou l\'expression avec des crochets : [votre mot].',
            'rows'          => 3,
            'new_lines'     => 'br',
        ],
        [
            'key'           => 'field_be_key_features_description',
            'label'         => 'Description',
            'name'          => 'description',
            'type'          => 'textarea',
            'rows'          => 4,
            'new_lines'     => 'br',
        ],
        [
            'key'           => 'field_be_key_features_items',
            'label'         => 'Fonctionnalités',
            'name'          => 'items',
            'type'          => 'repeater',
            'layout'        => 'block',
            'button_label'  => 'Ajouter une fonctionnalité',
            'min'           => 1,
            'max'           => 10,
            'sub_fields'    => [
                [
                    'key'       => 'field_be_key_features_item_text',
                    'label'     => 'Texte',
                    'name'      => 'text',
                    'type'      => 'text',
                ],
            ],
        ],
    ],
    'location' => [[[
        'param'    => 'block',
        'operator' => '==',
        'value'    => 'acf/be-key-features',
    ]]],
    'active' => true,
]);