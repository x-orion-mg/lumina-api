<?php

namespace Lumina\ApiV2\Transformers;

use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\Button;
use Lumina\ApiV2\Helpers\Icon;
use Lumina\ApiV2\Helpers\Media;

class HeaderTransformer
{
    /**
     * @param array<string, mixed> $data Champs options (header_*).
     */
    public static function transform(array $data, string $lang): array
    {
        return [
            'lang' => $lang,
            'topbar'=>[
                'text'=>$data['topbar_text'] ?? '',
                'background_color'=>$data['topbar_background_color'] ?? '',
                'text_color'=>$data['topbar_text_color'] ?? '',
                'phone_link'=>$data['topbar_phone_link'] ?? '',
                'account_link'=>$data['topbar_account_link'] ?? '',
            ],
            'main_header'=>[
                'logo' => Media::image($data['main_header_logo'] ?? null),
                'reseller_logo' => Media::image($data['reseller_logo'] ?? null),
                'reseller_label' => $data['reseller_label'] ?? null,
                'reseller_authorization_link' =>Button::parse($data['reseller_authorization_link'] ?? null),
                'search_placeholder' =>$data['search_placeholder'] ?? null,
                'search_button_label' => $data['search_button_label'] ?? null,
            ],
            'cta' => Button::parse($data['navigation_cta'] ?? null),
            'show_language_switcher' => (bool) ($data['header_show_language_switcher'] ?? true),
            'navigation' => self::navigation($data['navigation_items'] ?? []),
        ];
    }

    /**
     * @param mixed $items
     */
    /**
     * Transforme les éléments de navigation ACF.
     *
     * Types :
     * - menu      : menu WordPress avec sa hiérarchie.
     * - mega_menu : menu WordPress + contenu et image du méga-menu.
     * - link      : lien personnalisé.
     *
     * @param mixed $items
     * @return array<int, array<string, mixed>>
     */
    private static function navigation($items): array
    {
        return AcfRepeater::parse(
            $items,
            static function (array $item): array {
                $type = $item['type'] ?? 'menu';

                /*
                 * Lien personnalisé
                 */
                if ($type === 'link') {
                    $link = Button::parse($item['link'] ?? null);

                    return [
                        'type'  => 'link',
                        'label' => $link['title'] ?? '',
                        'link'  => $link,
                    ];
                }

                /*
                 * Menu WordPress
                 */
                $menuId = absint($item['menu'] ?? 0);
                $menu = self::getWordPressMenu($menuId);

                if ($type === 'mega_menu') {
                    return [
                        'type'        => 'mega_menu',
                        'menu_id'     => $menu['menu_id'],
                        'items'       => $menu['items'],
                        'mega_menu'   => self::megaMenu($item),
                    ];
                }

                return [
                    'type'    => 'menu',
                    'menu_id' => $menu['menu_id'],
                    'items'   => $menu['items'],
                ];
            }
        );
    }

    /**
     * Récupère un menu WordPress et ses éléments hiérarchiques.
     *
     * @param int $menuId Identifiant du menu WordPress.
     * @return array<string, mixed>
     */
    private static function getWordPressMenu(int $menuId): array
    {
        if ($menuId <= 0) {
            return [
                'menu_id' => null,
                'label'   => '',
                'items'   => [],
            ];
        }

        $menu = wp_get_nav_menu_object($menuId);

        if (!$menu || is_wp_error($menu)) {
            return [
                'menu_id' => null,
                'label'   => '',
                'items'   => [],
            ];
        }

        $menuItems = wp_get_nav_menu_items($menuId);

        if (is_wp_error($menuItems) || !is_array($menuItems)) {
            $menuItems = [];
        }

        return [
            'menu_id' => (int) $menu->term_id,
            'label'   => $menu->name,
            'items'   => self::buildMenuTree($menuItems),
        ];
    }

    /**
     * Construit l'arborescence d'un menu WordPress.
     *
     * Les enfants sont identifiés par menu_item_parent.
     *
     * @param array $items Éléments plats du menu WordPress.
     * @param int   $parentId Identifiant du parent.
     * @return array<int, array<string, mixed>>
     */
    private static function buildMenuTree(
        array $items,
        int $parentId = 0
    ): array {
        $tree = [];

        foreach ($items as $item) {
            if ((int) $item->menu_item_parent !== $parentId) {
                continue;
            }

            $tree[] = [
                'id'          => (int) $item->ID,
                'title'       => $item->title,
                'url'         => $item->url,
                'target'      => $item->target ?: null,
                'description' => $item->description ?: '',
                'attr_title'  => $item->attr_title ?: '',
                'classes'     => array_values(
                    array_filter((array) $item->classes)
                ),
                'type'        => $item->type,
                'object'      => $item->object,
                'object_id'   => (int) $item->object_id,
                'children'    => self::buildMenuTree(
                    $items,
                    (int) $item->ID
                ),
            ];
        }

        return $tree;
    }

    /**
     * Transforme les données complémentaires d'un méga-menu.
     *
     * @param array<string, mixed> $mega
     * @return array<string, mixed>
     */
    private static function megaMenu(array $mega): array
    {
        return [
            'image'       => Media::image(
                $mega['mega_menu_image'] ?? null
            ),
            'eyebrow'     => $mega['eyebrow'] ?? '',
            'title'       => $mega['title'] ?? '',
            'description' => $mega['description'] ?? '',
            'price'       => $mega['price'] ?? '',
            'link'        => Button::parse($mega['link'] ?? null),
        ];
    }
}
