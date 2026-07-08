<?php

use Lumina\ApiV2\Acf\ButtonFields;

$helpButtonFields = ButtonFields::group(
    'help_',
    'Bouton aide'
);

acf_add_local_field_group([
    'key' => 'group_be_legal_documents_navigation',
    'title' => 'Block - Legal Documents Navigation',
    'fields' => array_merge([
        [
            'key' => 'field_be_legal_documents_navigation_search_placeholder',
            'label' => 'Placeholder recherche',
            'name' => 'search_placeholder',
            'type' => 'text',
            'default_value' => 'Rechercher une section...',
        ],
        [
            'key'           => 'field_be_legal_documents_navigation_icon',
            'label'         => 'Icône',
            'name'          => 'icon_lumina',
            'type'          => 'select',
            'ui'            => 1,
            'allow_null'    => 1,
            'return_format' => 'value',
        ],
        [
            'key'   => 'field_be_legal_documents_navigation_label',
            'label' => 'Label',
            'name'  => 'label',
            'type'  => 'text',
        ],

        [
            'key'   => 'field_be_legal_documents_navigation_title',
            'label' => 'Titre',
            'name'  => 'title',
            'type'  => 'text',
        ],
        [
            'key'   => 'field_be_legal_documents_navigation_title_section',
            'label' => 'Titre section',
            'name'  => 'title_section',
            'type'  => 'text',
            'default_value' => 'En cours de lecture',
        ],
        [
            'key'   => 'field_be_legal_documents_navigation_last_update',
            'label' => 'Dernière mise à jour',
            'name'  => 'last_update',
            'type'  => 'text',
            'default_value' => 'Dernière mise à jour · 23 février 2026',
        ],
        [
            'key' => 'field_be_legal_documents_navigation_documents_tab',
            'label' => 'Documents',
            'type' => 'tab',
            'placement' => 'top',
        ],

        [
            'key' => 'field_be_legal_documents_navigation_documents',
            'label' => 'Documents',
            'name' => 'documents',
            'type' => 'repeater',
            'layout' => 'table',
            'button_label' => 'Ajouter un document',
            'min' => 1,
            'sub_fields' => [
                [
                    'key' => 'field_be_legal_documents_navigation_document_link',
                    'label' => 'Lien',
                    'name' => 'link',
                    'type' => 'link',
                    'return_format' => 'array',
                ],
            ],
        ],
        [
            'key' => 'field_be_legal_documents_navigation_help_tab',
            'label' => 'Besoin d\'aide',
            'type' => 'tab',
            'placement' => 'top',
        ],

        [
            'key' => 'field_be_legal_documents_navigation_help_title',
            'label' => 'Titre',
            'name' => 'help_title',
            'type' => 'text',
        ],

        [
            'key' => 'field_be_legal_documents_navigation_help_description',
            'label' => 'Description',
            'name' => 'help_description',
            'type' => 'textarea',
            'rows' => 3,
            'new_lines' => 'br',
        ],
    ], $helpButtonFields),
    'location' => [[[
        'param' => 'block',
        'operator' => '==',
        'value' => 'acf/be-legal-documents-navigation',
    ]]],
    'active' => true,
]);