<?php


namespace Lumina\ApiV2\Options\Settings;

use Lumina\ApiV2\Contracts\Registerable;
use Lumina\ApiV2\Core\Config;

class WooCommerce implements Registerable
{
    public static function register(): void
    {
        acf_add_local_field_group([

            'key' => 'group_lumina_settings_woocommerce',

            'title' => 'WooCommerce',

            'fields' => [

                [
                    'key' => 'field_wc_cancel_unpaid_orders_interval',
                    'label' => 'Délai d’annulation des commandes impayées',
                    'name' => 'wc_cancel_unpaid_orders_interval',
                    'type' => 'select',
                    'instructions' => 'Définit après combien de temps WooCommerce annule automatiquement les commandes non payées.',
                    'choices' => [
                        'hour' => '1 heure',
                        'day' => '24 heures',
                        'week' => '7 jours',
                    ],
                    'default_value' => 'day',
                    'ui' => 1,
                    'return_format' => 'value',
                ],

            ],

            'location' => [
                [
                    [
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => Config::OPTIONS_SLUG_SETTINGS,
                    ],
                ],
            ],

            'active' => true,

        ]);
    }
}