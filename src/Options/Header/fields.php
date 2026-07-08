<?php

use Lumina\ApiV2\Core\Config;

acf_add_local_field_group([

    'key' => 'group_lumina_header_v2',

    'title' => 'Header (API v2)',

    'fields' => [

        [
            'key' => 'field_be_header_tab_general',
            'label' => 'Général',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ],

        [
            'key' => 'field_be_header_logo',
            'label' => 'Logo',
            'name' => 'header_logo',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ],

        [
            'key' => 'field_be_header_phone',
            'label' => 'Numéro de téléphone',
            'name' => 'header_phone',
            'type' => 'text',
            'placeholder' => '+33 (0)1 86 65 48 80',
        ],

        [
            'key' => 'field_be_header_cta',
            'label' => 'Bouton CTA (ex. Demander une démo)',
            'name' => 'header_cta',
            'type' => 'link',
            'return_format' => 'array',
        ],

        [
            'key' => 'field_be_header_show_lang',
            'label' => 'Afficher le sélecteur de langue',
            'name' => 'header_show_language_switcher',
            'type' => 'true_false',
            'ui' => 1,
            'default_value' => 1,
        ],

        [
            'key' => 'field_be_header_tab_nav',
            'label' => 'Navigation',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ],

        [
            'key' => 'field_be_header_nav',
            'label' => 'Éléments du menu',
            'name' => 'header_nav',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Ajouter un élément',
            'min' => 1,
            'sub_fields' => [

                [
                    'key' => 'field_be_header_nav_label',
                    'label' => 'Libellé',
                    'name' => 'label',
                    'type' => 'text',
                    'required' => 1,
                ],

                [
                    'key' => 'field_be_header_nav_type',
                    'label' => 'Type',
                    'name' => 'type',
                    'type' => 'select',
                    'choices' => [
                        'link'       => 'Lien simple',
                        'mega_menu'  => 'Mega menu',
                    ],
                    'default_value' => 'link',
                    'ui' => 1,
                    'return_format' => 'value',
                ],

                [
                    'key' => 'field_be_header_nav_link',
                    'label' => 'Lien',
                    'name' => 'link',
                    'type' => 'link',
                    'return_format' => 'array',
                    'conditional_logic' => [
                        [
                            [
                                'field' => 'field_be_header_nav_type',
                                'operator' => '==',
                                'value' => 'link',
                            ],
                        ],
                    ],
                ],

                [
                    'key' => 'field_be_header_nav_mega',
                    'label' => 'Mega menu',
                    'name' => 'mega_menu',
                    'type' => 'group',
                    'layout' => 'block',
                    'conditional_logic' => [
                        [
                            [
                                'field' => 'field_be_header_nav_type',
                                'operator' => '==',
                                'value' => 'mega_menu',
                            ],
                        ],
                    ],
                    'sub_fields' => [

                        [
                            'key' => 'field_be_header_mega_title',
                            'label' => 'Titre du panneau',
                            'name' => 'title',
                            'type' => 'text',
                        ],

                        [
                            'key' => 'field_be_header_mega_description',
                            'label' => 'Description',
                            'name' => 'description',
                            'type' => 'textarea',
                            'rows' => 3,
                            'new_lines' => 'br',
                        ],

                        [
                            'key' => 'field_be_header_mega_links',
                            'label' => 'Liens (colonne gauche)',
                            'name' => 'links',
                            'type' => 'repeater',
                            'layout' => 'table',
                            'button_label' => 'Ajouter un lien',
                            'sub_fields' => [
                                [
                                    'key' => 'field_be_header_mega_link_item',
                                    'label' => 'Lien',
                                    'name' => 'link',
                                    'type' => 'link',
                                    'return_format' => 'array',
                                ],
                            ],
                        ],

                        [
                            'key' => 'field_be_header_mega_highlights',
                            'label' => 'Cartes (colonne droite)',
                            'name' => 'highlights',
                            'type' => 'repeater',
                            'layout' => 'block',
                            'button_label' => 'Ajouter une carte',
                            'sub_fields' => [

                                [
                                    'key' => 'field_be_header_mega_highlight_icon',
                                    'label' => 'Icône',
                                    'name' => 'icon_lumina',
                                    'type' => 'select',
                                    'ui' => 1,
                                    'allow_null' => 1,
                                    'return_format' => 'value',
                                ],

                                [
                                    'key' => 'field_be_header_mega_highlight_title',
                                    'label' => 'Titre',
                                    'name' => 'title',
                                    'type' => 'text',
                                ],

                                [
                                    'key' => 'field_be_header_mega_highlight_description',
                                    'label' => 'Description',
                                    'name' => 'description',
                                    'type' => 'textarea',
                                    'rows' => 3,
                                ],

                                [
                                    'key' => 'field_be_header_mega_highlight_link',
                                    'label' => 'Lien (optionnel)',
                                    'name' => 'link',
                                    'type' => 'link',
                                    'return_format' => 'array',
                                ],

                            ],
                        ],

                    ],
                ],

            ],
        ],

    ],

    'location' => [
        [
            [
                'param' => 'options_page',
                'operator' => '==',
                'value' => Config::OPTIONS_SLUG,
            ],
        ],
    ],

    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'active' => true,

]);
