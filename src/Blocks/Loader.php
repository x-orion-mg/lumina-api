<?php

namespace Lumina\ApiV2\Blocks;

class Loader
{
    public static function init(): void
    {
        add_filter('block_categories_all', [self::class, 'registerBlockCategory'], 10, 2);
        add_action('acf/init', [self::class, 'registerBlocks']);
    }

    public static function registerBlockCategory(array $categories, $editorContext): array
    {
        $categories[] = [
            'slug'  => 'lumina',
            'title' => 'Lumina',
        ];

        return $categories;
    }

    public static function registerBlocks(): void
    {
        if (!function_exists('acf_register_block_type')) {
            return;
        }

        foreach (glob(__DIR__ . '/*', GLOB_ONLYDIR) as $dir) {
            $config = $dir . '/config.php';

            if (file_exists($config)) {
                $block = include $config;

                if (is_array($block)) {
                    acf_register_block_type($block);
                }
            }

            if (file_exists($dir . '/fields.php')) {
                require_once $dir . '/fields.php';
            }
        }
    }
}
