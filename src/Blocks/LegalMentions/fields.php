<?php

acf_add_local_field_group([
    'key'      => 'group_be_legal_mentions',
    'title'    => 'Block - Mentions légales',
    'fields'   => [
        [
            'key'           => 'field_be_legal_mentions_title',
            'label'         => 'Titre',
            'name'          => 'title',
            'type'          => 'text',
            'instructions'  => 'Pour appliquer un effet de dégradé (gradient) à un texte, encadrez le mot ou l\'expression avec des crochets : [votre mot].',
        ],
        [
            'key'           => 'field_be_legal_mentions_description',
            'label'         => 'Description',
            'name'          => 'description',
            'type'          => 'textarea',
            'rows'          => 2,
            'new_lines'     => 'br',
        ],
        [
            'key'           => 'field_be_legal_mentions_sections',
            'label'         => 'Sections',
            'name'          => 'sections',
            'type'          => 'repeater',
            'layout'        => 'block',
            'button_label'  => 'Ajouter une section',
            'min'           => 1,
            'sub_fields'    => [
                [
                    'key'           => 'field_be_legal_mentions_sections_title',
                    'label'         => 'Titre de la section',
                    'name'          => 'title',
                    'type'          => 'text',
                ],
                [
                    'key'           => 'field_be_legal_mentions_sections_content',
                    'label'         => 'Contenu',
                    'name'          => 'content',
                    'type'          => 'wysiwyg',
                    'tabs'          => 'all',
                    'toolbar'       => 'full',
                    'media_upload'  => 0,
                ],
            ],
        ],
    ],
    'location' => [[[
        'param'    => 'block',
        'operator' => '==',
        'value'    => 'acf/be-legal-mentions',
    ]]],
    'active'   => true,
]);