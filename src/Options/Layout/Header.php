<?php

namespace Lumina\ApiV2\Options\Layout;

use Lumina\ApiV2\Contracts\Registerable;
use Lumina\ApiV2\Core\Config;

class Header implements Registerable
{
    public static function register(): void
    {
        acf_add_local_field_group([
            'key' => 'group_lumina_header_v2',
            'title' => 'Header (API v2)',

            'fields' => [

                /*
                 * =====================================================
                 * TOPBAR
                 * =====================================================
                 */

                [
                    'key' => 'field_lumina_header_v2_tab_topbar',
                    'label' => 'Topbar',
                    'name' => '',
                    'type' => 'tab',
                    'placement' => 'top',
                ],

                [
                    'key' => 'field_lumina_header_v2_topbar_text',
                    'label' => 'Texte promotionnel',
                    'name' => 'topbar_text',
                    'type' => 'text',
                    'default_value' => 'Découvrez nos produits Lumina et profitez de -10 % sur votre premier achat !',
                    'placeholder' => 'Votre message promotionnel...',
                    'maxlength' => 255,
                ],

                [
                    'key' => 'field_lumina_header_v2_topbar_background',
                    'label' => 'Couleur de fond',
                    'name' => 'topbar_background_color',
                    'type' => 'color_picker',
                    'default_value' => '#1B1B68',
                    'enable_opacity' => 0,
                    'return_format' => 'string',
                    'wrapper' => array(
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ),
                ],

                [
                    'key' => 'field_lumina_header_v2_topbar_text_color',
                    'label' => 'Couleur du texte',
                    'name' => 'topbar_text_color',
                    'type' => 'color_picker',
                    'default_value' => '#FFFFFF',
                    'enable_opacity' => 0,
                    'return_format' => 'string',
                    'wrapper' => array(
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ),
                ],

                [
                    'key' => 'field_lumina_header_v2_topbar_phone_link',
                    'label' => 'Lien Téléphone',
                    'name' => 'topbar_phone_link',
                    'type' => 'link',
                    'return_format' => 'array',
                    'instructions' => 'Lien vers la page de contact ou le numéro de téléphone cliquable.',
                    'wrapper' => array(
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ),
                ],

                [
                    'key' => 'field_lumina_header_v2_topbar_account_link',
                    'label' => 'Lien Mon compte',
                    'name' => 'topbar_account_link',
                    'type' => 'link',
                    'return_format' => 'array',
                    'instructions' => 'Lien vers la page Mon compte WooCommerce.',
                    'wrapper' => array(
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ),
                ],

                /*
                 * =====================================================
                 * MAIN HEADER
                 * =====================================================
                 */

                [
                    'key' => 'field_lumina_header_v2_tab_main_header',
                    'label' => 'En-tête principal',
                    'name' => '',
                    'type' => 'tab',
                    'placement' => 'top',
                ],

                [
                    'key' => 'field_lumina_header_v2_logo',
                    'label' => 'Logo du site',
                    'name' => 'main_header_logo',
                    'type' => 'image',
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'library' => 'all',
                    'required' => 1,
                ],

                [
                    'key' => 'field_lumina_header_v2_search_placeholder',
                    'label' => 'Placeholder de recherche',
                    'name' => 'search_placeholder',
                    'type' => 'text',
                    'default_value' => 'Rechercher un produit, une référence ou une gamme Lumina...',
                    'placeholder' => 'Rechercher...',
                    'maxlength' => 255,
                ],

                [
                    'key' => 'field_lumina_header_v2_search_button_label',
                    'label' => 'Libellé du bouton de recherche',
                    'name' => 'search_button_label',
                    'type' => 'text',
                    'default_value' => 'Rechercher',
                    'maxlength' => 100,
                ],

                [
                    'key' => 'field_lumina_header_v2_reseller_logo',
                    'label' => 'Logo du revendeur agréé',
                    'name' => 'reseller_logo',
                    'type' => 'image',
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'library' => 'all',
                    'instructions' => 'Logo du fabricant ou du partenaire dont la marque est commercialisée.',
                ],

                [
                    'key' => 'field_lumina_header_v2_reseller_label',
                    'label' => 'Texte au-dessus du logo revendeur',
                    'name' => 'reseller_label',
                    'type' => 'text',
                    'default_value' => 'Revendeur agréé',
                    'maxlength' => 100,
                ],

                [
                    'key' => 'field_lumina_header_v2_reseller_authorization_link',
                    'label' => 'Lien vers l’autorisation',
                    'name' => 'reseller_authorization_link',
                    'type' => 'link',
                    'return_format' => 'array',
                    'instructions' => 'Lien vers la page ou le document justifiant l’autorisation de revente.',
                ],

                /*
                 * =====================================================
                 * NAVIGATION
                 * =====================================================
                 */

                [
                    'key' => 'field_lumina_header_v2_tab_navigation',
                    'label' => 'Navigation',
                    'name' => '',
                    'type' => 'tab',
                    'placement' => 'top',
                ],

                [
                    'key' => 'field_lumina_header_v2_nav_items',
                    'label' => 'Éléments du menu',
                    'name' => 'navigation_items',
                    'type' => 'repeater',
                    'layout' => 'block',
                    'button_label' => 'Ajouter un élément',
                    'min' => 0,

                    'sub_fields' => [

                        /*
                         * Type d'élément
                         */

                        [
                            'key' => 'field_lumina_header_v2_nav_type',
                            'label' => 'Type d’élément',
                            'name' => 'type',
                            'type' => 'select',
                            'choices' => [
                                'menu'      => 'Menu WordPress',
                                'mega_menu' => 'Méga-menu',
                                'link'      => 'Lien personnalisé',
                            ],
                            'default_value' => 'menu',
                            'ui' => 1,
                            'return_format' => 'value',
                            'required' => 1,
                        ],

                        /*
                         * Menu WordPress
                         *
                         * Affiché pour :
                         * - Menu WordPress
                         * - Méga-menu
                         */

                        [
                            'key' => 'field_lumina_header_v2_nav_menu',
                            'label' => 'Menu WordPress',
                            'name' => 'menu',
                            'type' => 'select',
                            'choices' => self::getWordPressMenus(),
                            'allow_null' => 1,
                            'ui' => 1,
                            'return_format' => 'value',
                            'required' => 1,

                            'conditional_logic' => [
                                [
                                    [
                                        'field' => 'field_lumina_header_v2_nav_type',
                                        'operator' => '==',
                                        'value' => 'menu',
                                    ],
                                ],
                                [
                                    [
                                        'field' => 'field_lumina_header_v2_nav_type',
                                        'operator' => '==',
                                        'value' => 'mega_menu',
                                    ],
                                ],
                            ],
                        ],

                        /*
                         * Image du méga-menu
                         */

                        [
                            'key' => 'field_lumina_header_v2_nav_mega_image',
                            'label' => 'Image du méga-menu',
                            'name' => 'mega_menu_image',
                            'type' => 'image',
                            'return_format' => 'array',
                            'preview_size' => 'medium',
                            'library' => 'all',

                            'conditional_logic' => [
                                [
                                    [
                                        'field' => 'field_lumina_header_v2_nav_type',
                                        'operator' => '==',
                                        'value' => 'mega_menu',
                                    ],
                                ],
                            ],
                        ],
                        [
                            'key' => 'field_lumina_header_v2_nav_mega_eyebrow',
                            'label' => 'Surtitre',
                            'name' => 'eyebrow',
                            'type' => 'text',

                            'wrapper' => [
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ],

                            'default_value' => '',
                            'conditional_logic' => [
                                [
                                    [
                                        'field' => 'field_lumina_header_v2_nav_type',
                                        'operator' => '==',
                                        'value' => 'mega_menu',
                                    ],
                                ],
                            ],
                        ],

                        [
                            'key' => 'field_lumina_header_v2_nav_mega_title',
                            'label' => 'Titre',
                            'name' => 'title',
                            'type' => 'textarea',

                            'wrapper' => [
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ],

                            'default_value' => '',
                            'rows' => 3,
                            'new_lines' => 'br',
                            'conditional_logic' => [
                                [
                                    [
                                        'field' => 'field_lumina_header_v2_nav_type',
                                        'operator' => '==',
                                        'value' => 'mega_menu',
                                    ],
                                ],
                            ],
                        ],

                        [
                            'key' => 'field_lumina_header_v2_nav_mega_description',
                            'label' => 'Description',
                            'name' => 'description',
                            'type' => 'textarea',

                            'wrapper' => [
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ],

                            'default_value' => '',
                            'rows' => 3,
                            'new_lines' => 'br',
                            'conditional_logic' => [
                                [
                                    [
                                        'field' => 'field_lumina_header_v2_nav_type',
                                        'operator' => '==',
                                        'value' => 'mega_menu',
                                    ],
                                ],
                            ],
                        ],
                        [
                            'key' => 'field_lumina_header_v2_nav_mega_price',
                            'label' => 'Prix',
                            'name' => 'price',
                            'type' => 'text',
                            'instructions' => 'Texte libre permettant de contrôler exactement l’affichage du prix.',
                            'required' => 0,

                            'wrapper' => [
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ],

                            'default_value' => '',
                            'conditional_logic' => [
                                [
                                    [
                                        'field' => 'field_lumina_header_v2_nav_type',
                                        'operator' => '==',
                                        'value' => 'mega_menu',
                                    ],
                                ],
                            ],
                        ],
                        [
                            'key' => 'field_lumina_header_v2_nav_mega_link',
                            'label' => 'Lien',
                            'name' => 'link',
                            'type' => 'link',
                            'return_format' => 'array',
                            'required' => 1,

                            'conditional_logic' => [
                                [
                                    [
                                        'field' => 'field_lumina_header_v2_nav_type',
                                        'operator' => '==',
                                        'value' => 'mega_menu',
                                    ],
                                ],
                            ],
                        ],

                        /*
                         * Lien personnalisé
                         */

                        [
                            'key' => 'field_lumina_header_v2_nav_link',
                            'label' => 'Lien',
                            'name' => 'link',
                            'type' => 'link',
                            'return_format' => 'array',
                            'required' => 1,

                            'conditional_logic' => [
                                [
                                    [
                                        'field' => 'field_lumina_header_v2_nav_type',
                                        'operator' => '==',
                                        'value' => 'link',
                                    ],
                                ],
                            ],
                        ],

                    ],
                ],

                /*
                 * CTA à droite de la navigation
                 */

                [
                    'key' => 'field_lumina_header_v2_nav_cta_tab',
                    'label' => 'Bouton CTA',
                    'name' => '',
                    'type' => 'tab',
                    'placement' => 'top',
                ],

                [
                    'key' => 'field_lumina_header_v2_nav_cta_enabled',
                    'label' => 'Afficher le bouton CTA',
                    'name' => 'navigation_cta_enabled',
                    'type' => 'true_false',
                    'ui' => 1,
                    'default_value' => 1,
                ],

                [
                    'key' => 'field_lumina_header_v2_nav_cta',
                    'label' => 'Bouton CTA',
                    'name' => 'navigation_cta',
                    'type' => 'link',
                    'return_format' => 'array',
                    'conditional_logic' => [
                        [
                            [
                                'field' => 'field_lumina_header_v2_nav_cta_enabled',
                                'operator' => '==',
                                'value' => '1',
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
                        'value' => Config::OPTIONS_SLUG_SETTINGS_LAYOUT,
                    ],
                ],
            ],

            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'active' => true,
            'show_in_rest' => 0,
        ]);
    }

    /**
     * Retourne les menus WordPress disponibles pour ACF.
     *
     * @return array<string, string>
     */
    private static function getWordPressMenus(): array
    {
        $choices = [];

        $menus = wp_get_nav_menus();

        foreach ($menus as $menu) {
            $choices[(string) $menu->term_id] = $menu->name;
        }

        return $choices;
    }
}