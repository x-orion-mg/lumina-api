<?php

namespace Lumina\ApiV2\WooCommerce\Hooks;

class RegistrationEmail
{
    public static function register(): void
    {
        add_filter(
            'woocommerce_locate_template',
            [self::class, 'locateTemplate'],
            10,
            3
        );
    }

    public static function locateTemplate(
        string $template,
        string $template_name,
        string $template_path
    ): string {

        if ($template_name !== 'emails/customer-new-account.php') {
            return $template;
        }

        $pluginTemplate = LUMINA_API_V2_PATH
            . '/templates/woocommerce/emails/customer-new-account.php';

        if (file_exists($pluginTemplate)) {
            return $pluginTemplate;
        }

        return $template;
    }
}