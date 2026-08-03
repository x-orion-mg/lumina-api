<?php


namespace Lumina\ApiV2\Options;

use Lumina\ApiV2\Contracts\Registerable;
use Lumina\ApiV2\Core\Config;

class Page implements Registerable
{
    public static function register(): void
    {
        if (!function_exists('acf_add_options_page')) {
            return;
        }

        $parent = Config::THEME_OPTIONS_SLUG;

        // Si le thème possède déjà un menu Theme Settings
        if (
            function_exists('acf_get_options_page')
            && acf_get_options_page($parent)
        ) {

            acf_add_options_sub_page([
                'page_title' => 'Lumina API v2',
                'menu_title' => 'Lumina v2',
                'menu_slug' => Config::OPTIONS_SLUG,
                'parent_slug' => $parent,
                'capability' => 'edit_posts',
                'redirect' => true,
            ]);

            return;
        }


        // Sinon création du menu principal
        acf_add_options_page([

            'page_title' => 'Lumina API v2',

            'menu_title' => 'Lumina v2',

            'menu_slug' => Config::OPTIONS_SLUG,

            'capability' => 'edit_posts',

            'redirect' => true,

        ]);
    }
}