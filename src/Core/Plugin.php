<?php


namespace Lumina\ApiV2\Core;

use Lumina\ApiV2\Acf\IconField;
use Lumina\ApiV2\Blocks\Loader as BlocksLoader;
use Lumina\ApiV2\Options\Loader as OptionsLoader;

class Plugin
{
    public static function boot(): void
    {
        add_action('rest_api_init', [Router::class, 'registerRoutes']);
        BlocksLoader::init();

        if (function_exists('acf')) {
            IconField::init();
            OptionsLoader::init();
        }
    }
}