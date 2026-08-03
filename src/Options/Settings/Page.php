<?php

namespace Lumina\ApiV2\Options\Settings;

use Lumina\ApiV2\Contracts\Registerable;
use Lumina\ApiV2\Core\Config;

class Page implements Registerable
{
    public static function register(): void
    {
        acf_add_options_sub_page([
            'page_title'  => 'Réglages',
            'menu_title'  => 'Réglages',
            'menu_slug'   => Config::OPTIONS_SLUG_SETTINGS,
            'parent_slug' => Config::OPTIONS_SLUG,
            'capability' => 'edit_posts',
        ]);
    }
}