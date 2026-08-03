<?php
namespace Lumina\ApiV2\Options\Layout;

use Lumina\ApiV2\Acf\ButtonFields;
use Lumina\ApiV2\Contracts\Registerable;
use Lumina\ApiV2\Core\Config;
class Others implements Registerable
{
    public static function register(): void
    {
        $helpButtonFields = ButtonFields::group(
            'legal_help_',
            'Bouton aide'
        );

        acf_add_local_field_group([
            'key' => 'group_lumina_others_v2',
            'title' => 'Others (API v2) - Legal Documents Navigation',
            'fields' => array_merge([
                [
                    'key' => 'field_be_others_legal_search_placeholder',
                    'label' => 'Placeholder recherche',
                    'name' => 'legal_search_placeholder',
                    'type' => 'text',
                    'default_value' => 'Rechercher une section...',
                ],
                [
                    'key'   => 'field_be_others_legal_title_section',
                    'label' => 'Titre section',
                    'name'  => 'legal_title_section',
                    'type'  => 'text',
                    'default_value' => 'En cours de lecture',
                ],
                [
                    'key'   => 'field_be_others_legal_last_update',
                    'label' => 'Dernière mise à jour',
                    'name'  => 'legal_last_update',
                    'type'  => 'text',
                    'default_value' => 'Dernière mise à jour · 23 février 2026',
                ],
                [
                    'key' => 'field_be_others_legal_documents_tab',
                    'label' => 'Documents',
                    'type' => 'tab',
                    'placement' => 'top',
                ],

                [
                    'key' => 'field_be_others_legal_documents_title',
                    'label' => 'Titre',
                    'name' => 'legal_documents_title',
                    'type' => 'text',
                    'default_value' => 'Documents',
                ],
                [
                    'key' => 'field_be_others_legal_documents',
                    'label' => 'Documents',
                    'name' => 'legal_documents',
                    'type' => 'repeater',
                    'layout' => 'table',
                    'button_label' => 'Ajouter un document',
                    'min' => 1,
                    'sub_fields' => [
                        [
                            'key' => 'field_be_others_legal_document_link',
                            'label' => 'Lien',
                            'name' => 'link',
                            'type' => 'link',
                            'return_format' => 'array',
                        ],
                    ],
                ],
                [
                    'key' => 'field_be_others_legal_help_tab',
                    'label' => 'Besoin d\'aide',
                    'type' => 'tab',
                    'placement' => 'top',
                ],
                [
                    'key' => 'field_be_others_legal_help_title',
                    'label' => 'Titre',
                    'name' => 'legal_help_title',
                    'type' => 'text',
                    'default_value' => 'Besoin d\'aide ?',
                ],
                [
                    'key' => 'field_be_others_legal_help_description',
                    'label' => 'Description',
                    'name' => 'legal_help_description',
                    'type' => 'textarea',
                    'rows' => 3,
                    'new_lines' => 'br',
                    'default_value' => 'Une question sur ce document ? Écrivez-nous à',
                ],
            ], $helpButtonFields),
            'location' => [
                [
                    [
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => Config::OPTIONS_SLUG_SETTINGS_LAYOUT,
                    ],
                ],
            ],
            'menu_order' => 10,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'active' => true,
        ]);
    }
}

