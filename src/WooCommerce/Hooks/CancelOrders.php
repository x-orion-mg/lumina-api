<?php

namespace Lumina\ApiV2\WooCommerce\Hooks;

use Lumina\ApiV2\Options\Settings\WooCommerce as WooCommerceSettings;

class CancelOrders
{
    public static function register(): void
    {
        add_filter(
            'woocommerce_cancel_unpaid_orders_interval',
            [self::class, 'interval']
        );
    }


    public static function interval(): int
    {
        $value = get_field(
            'wc_cancel_unpaid_orders_interval',
            'option'
        );

        return match ($value) {
            'hour' => HOUR_IN_SECONDS,
            'week' => WEEK_IN_SECONDS,
            default => DAY_IN_SECONDS,
        };
    }
}