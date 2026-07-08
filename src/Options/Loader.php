<?php

namespace Lumina\ApiV2\Options;

use Lumina\ApiV2\Core\Config;

class Loader
{
    public static function init(): void
    {
        add_action('acf/init', [self::class, 'registerOptionsPage']);
        add_action('acf/init', [self::class, 'registerFieldGroups']);
    }

    public static function registerOptionsPage(): void
    {
        if (!function_exists('acf_add_options_page')) {
            return;
        }

        $parent = Config::THEME_OPTIONS_SLUG;

        if (function_exists('acf_get_options_page') && acf_get_options_page($parent)) {
            acf_add_options_sub_page([
                'page_title'  => 'Lumina API v2',
                'menu_title'  => 'Lumina v2',
                'menu_slug'   => Config::OPTIONS_SLUG,
                'parent_slug' => $parent,
                'capability'  => 'edit_posts',
                'redirect'    => false,
            ]);

            return;
        }

        acf_add_options_page([
            'page_title' => 'Lumina API v2',
            'menu_title' => 'Lumina v2',
            'menu_slug'  => Config::OPTIONS_SLUG,
            'capability' => 'edit_posts',
            'redirect'   => false,
        ]);
    }

    public static function registerFieldGroups(): void
    {
        foreach (glob(__DIR__ . '/*', GLOB_ONLYDIR) as $dir) {
            $fieldsFile = $dir . '/fields.php';

            if (file_exists($fieldsFile)) {
                require_once $fieldsFile;
            }
        }
    }
}
