<?php

namespace Lumina\ApiV2\WooCommerce\Hooks;

class TemplateLoader
{
    public static function register(): void
    {
        add_filter(
            'woocommerce_locate_template',
            [self::class, 'locateTemplate'],
            20,
            3
        );
    }

    public static function locateTemplate(
        string $template,
        string $templateName,
        string $templatePath
    ): string {

        $pluginTemplate = trailingslashit(LUMINA_API_V2_PATH)
            . 'templates/woocommerce/'
            . $templateName;

        if (file_exists($pluginTemplate)) {
            return $pluginTemplate;
        }

        return $template;
    }
}