<?php
namespace Lumina\ApiV2\Options\Layout;
use Lumina\ApiV2\Contracts\Registerable;
use Lumina\ApiV2\Core\Config;
class Footer implements Registerable
{
    public static function register(): void
    {
        acf_add_local_field_group([

            'key' => 'group_lumina_footer_v2',

            'title' => 'Footer (API v2)',

            'fields' => [

                [
                    'key' => 'field_be_footer_tab_branding',
                    'label' => 'Marque',
                    'name' => '',
                    'type' => 'tab',
                    'placement' => 'top',
                ],

                [
                    'key' => 'field_be_footer_logo',
                    'label' => 'Logo',
                    'name' => 'footer_logo',
                    'type' => 'image',
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'library' => 'all',
                ],

                [
                    'key' => 'field_be_footer_description',
                    'label' => 'Description',
                    'name' => 'footer_description',
                    'type' => 'textarea',
                    'rows' => 3,
                    'new_lines' => 'br',
                    'placeholder' => 'Bâtir la confiance grâce à un signalement simple et sécurisé.',
                ],

                [
                    'key' => 'field_be_footer_tab_columns',
                    'label' => 'Colonnes',
                    'name' => '',
                    'type' => 'tab',
                    'placement' => 'top',
                ],

                [
                    'key' => 'field_be_footer_columns',
                    'label' => 'Colonnes du footer',
                    'name' => 'footer_columns',
                    'type' => 'repeater',
                    'layout' => 'block',
                    'button_label' => 'Ajouter une colonne',
                    'min' => 1,
                    'sub_fields' => [

                        [
                            'key' => 'field_be_footer_column_title',
                            'label' => 'Titre de colonne',
                            'name' => 'title',
                            'type' => 'text',
                            'required' => 1,
                            'placeholder' => 'SOLUTIONS',
                        ],

                        [
                            'key' => 'field_be_footer_column_type',
                            'label' => 'Type de colonne',
                            'name' => 'type',
                            'type' => 'select',
                            'choices' => [
                                'links'           => 'Liste de liens',
                                'certifications'  => 'Certifications / badges',
                            ],
                            'default_value' => 'links',
                            'ui' => 1,
                            'return_format' => 'value',
                        ],

                        [
                            'key' => 'field_be_footer_column_links',
                            'label' => 'Liens',
                            'name' => 'links',
                            'type' => 'repeater',
                            'layout' => 'table',
                            'button_label' => 'Ajouter un lien',
                            'sub_fields' => [
                                [
                                    'key' => 'field_be_footer_column_link_item',
                                    'label' => 'Lien',
                                    'name' => 'link',
                                    'type' => 'link',
                                    'return_format' => 'array',
                                ],
                            ],
                            'conditional_logic' => [
                                [
                                    [
                                        'field' => 'field_be_footer_column_type',
                                        'operator' => '==',
                                        'value' => 'links',
                                    ],
                                ],
                            ],
                        ],

                        [
                            'key' => 'field_be_footer_column_certifications',
                            'label' => 'Certifications',
                            'name' => 'certifications',
                            'type' => 'repeater',
                            'layout' => 'block',
                            'button_label' => 'Ajouter une certification',
                            'sub_fields' => [
                                [
                                    'key' => 'field_be_footer_cert_label',
                                    'label' => 'Libellé',
                                    'name' => 'label',
                                    'type' => 'text',
                                    'placeholder' => 'ISO 27001',
                                ],
                                [
                                    'key' => 'field_be_footer_cert_badge',
                                    'label' => 'Badge (image)',
                                    'name' => 'badge',
                                    'type' => 'image',
                                    'return_format' => 'array',
                                    'preview_size' => 'thumbnail',
                                    'library' => 'all',
                                ],
                            ],
                            'conditional_logic' => [
                                [
                                    [
                                        'field' => 'field_be_footer_column_type',
                                        'operator' => '==',
                                        'value' => 'certifications',
                                    ],
                                ],
                            ],
                        ],

                    ],
                ],

                [
                    'key' => 'field_be_footer_tab_bottom',
                    'label' => 'Barre inférieure',
                    'name' => '',
                    'type' => 'tab',
                    'placement' => 'top',
                ],

                [
                    'key' => 'field_be_footer_copyright',
                    'label' => 'Copyright',
                    'name' => 'footer_copyright',
                    'type' => 'text',
                    'placeholder' => '© 2026 Lumina. Tous droits réservés.',
                ],

                [
                    'key' => 'field_be_footer_legal_links',
                    'label' => 'Liens légaux',
                    'name' => 'footer_legal_links',
                    'type' => 'repeater',
                    'layout' => 'table',
                    'button_label' => 'Ajouter un lien',
                    'sub_fields' => [
                        [
                            'key' => 'field_be_footer_legal_link_item',
                            'label' => 'Lien',
                            'name' => 'link',
                            'type' => 'link',
                            'return_format' => 'array',
                        ],
                    ],
                ],

                [
                    'key' => 'field_be_footer_social_links',
                    'label' => 'Réseaux sociaux',
                    'name' => 'footer_social_links',
                    'type' => 'repeater',
                    'layout' => 'table',
                    'button_label' => 'Ajouter un réseau',
                    'sub_fields' => [
                        [
                            'key' => 'field_be_footer_social_platform',
                            'label' => 'Plateforme',
                            'name' => 'platform',
                            'type' => 'select',
                            'choices' => [
                                'linkedin'  => 'LinkedIn',
                                'twitter'   => 'X (Twitter)',
                                'youtube'   => 'YouTube',
                                'facebook'  => 'Facebook',
                                'instagram' => 'Instagram',
                            ],
                            'ui' => 1,
                            'return_format' => 'value',
                            'required' => 1,
                        ],
                        [
                            'key' => 'field_be_footer_social_url',
                            'label' => 'URL',
                            'name' => 'url',
                            'type' => 'url',
                            'required' => 1,
                        ],
                    ],
                ],

            ],

            'location' => [
                [
                    [
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => Config::OPTIONS_SLUG. '-settings-layout',
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

