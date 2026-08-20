<?php

namespace Lumina\ApiV2\Options\PostTypes;

use Lumina\ApiV2\Contracts\Registerable;
use Lumina\ApiV2\Core\Config;
use Lumina\ApiV2\PostTypes\Admin\PostTypeSettingsPage;

class Page implements Registerable
{
    public static function register(): void
    {
        if (!function_exists('acf_add_options_sub_page')) {
            add_action('admin_menu', [self::class, 'registerFallbackMenu'], 999);

            return;
        }

        acf_add_options_sub_page([
            'page_title'  => 'Post Types',
            'menu_title'  => 'Post Types',
            'menu_slug'   => Config::OPTIONS_SLUG_POST_TYPES,
            'parent_slug' => Config::OPTIONS_SLUG,
            'capability'  => 'manage_options',
            'redirect'    => false,
        ]);

        add_action('admin_menu', [self::class, 'replaceRenderCallback'], 999);
    }

    /**
     * ACF enregistre le menu ; on remplace son callback par notre formulaire custom.
     * Priorité 999 : après l'enregistrement complet des menus ACF.
     */
    public static function replaceRenderCallback(): void
    {
        $slug = Config::OPTIONS_SLUG_POST_TYPES;
        $parent = self::resolveSubmenuParent($slug);

        if ($parent === null) {
            return;
        }

        remove_submenu_page($parent, $slug);

        add_submenu_page(
            $parent,
            'Post Types',
            'Post Types',
            'manage_options',
            $slug,
            [PostTypeSettingsPage::class, 'render']
        );
    }

    public static function registerFallbackMenu(): void
    {
        add_submenu_page(
            Config::THEME_OPTIONS_SLUG,
            'Post Types',
            'Post Types',
            'manage_options',
            Config::OPTIONS_SLUG_POST_TYPES,
            [PostTypeSettingsPage::class, 'render']
        );
    }

    private static function resolveSubmenuParent(string $slug): ?string
    {
        global $submenu;

        if (is_array($submenu)) {
            foreach ($submenu as $parent => $items) {
                if (!is_array($items)) {
                    continue;
                }

                foreach ($items as $item) {
                    if (($item[2] ?? '') === $slug) {
                        return (string) $parent;
                    }
                }
            }
        }

        if (function_exists('acf_get_options_page')) {
            $page = acf_get_options_page($slug);

            if (is_array($page) && !empty($page['parent_slug'])) {
                $parentSlug = (string) $page['parent_slug'];

                if ($parentSlug === Config::OPTIONS_SLUG) {
                    return Config::THEME_OPTIONS_SLUG;
                }

                return $parentSlug;
            }
        }

        return Config::THEME_OPTIONS_SLUG;
    }
}
