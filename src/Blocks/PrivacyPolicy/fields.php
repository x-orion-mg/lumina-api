<?php

acf_add_local_field_group([
    'key'      => 'group_be_privacy_policy',
    'title'    => 'Block - Politique de confidentialité',
    'fields'   => [
        [
            'key'   => 'field_be_privacy_policy_title',
            'label' => 'Titre',
            'name'  => 'title',
            'type'  => 'text',
            'instructions'  => 'Pour appliquer un effet de dégradé (gradient) à un texte, encadrez le mot ou l\'expression avec des crochets : [votre mot].',
        ],
        [
            'key'       => 'field_be_privacy_policy_description',
            'label'     => 'Description',
            'name'      => 'description',
            'type'      => 'textarea',
            'rows'      => 3,
            'new_lines' => 'br',
        ],
        [
            'key'          => 'field_be_privacy_policy_tabs',
            'label'        => 'Onglet',
            'name'         => 'tabs',
            'type'         => 'repeater',
            'layout'       => 'block',
            'button_label' => 'Ajouter une onglet',
            'min'          => 1,
            'sub_fields'   => [
                [
                    'key'           => 'field_be_privacy_policy_tab_icon',
                    'label'         => 'Icône',
                    'name'          => 'icon_lumina',
                    'type'          => 'select',
                    'ui'            => 1,
                    'allow_null'    => 1,
                    'return_format' => 'value',
                ],
                [
                    'key'   => 'field_be_privacy_policy_section_title',
                    'label' => 'Titre onglet',
                    'name'  => 'title',
                    'type'  => 'text',
                ],
                [
                    'key'          => 'field_be_privacy_policy_section_section',
                    'label'        => 'Section',
                    'name'         => 'section',
                    'type'         => 'repeater',
                    'layout'       => 'block',
                    'button_label' => 'Ajouter un section',
                    'min'          => 1,
                    'sub_fields'   => [
                        [
                            'key'   => 'field_be_privacy_policy_tab_title',
                            'label' => 'Titre',
                            'name'  => 'title',
                            'type'  => 'text',
                        ],
                        [
                            'key'          => 'field_be_privacy_policy_tab_content',
                            'label'        => 'Contenu',
                            'name'         => 'content',
                            'type'         => 'wysiwyg',
                            'tabs'         => 'all',
                            'toolbar'      => 'full',
                            'media_upload' => 0,
                        ],
                    ],
                ],
            ],
        ],
    ],
    'location' => [[[
        'param'    => 'block',
        'operator' => '==',
        'value'    => 'acf/be-privacy-policy',
    ]]],
    'active'   => true,
]);