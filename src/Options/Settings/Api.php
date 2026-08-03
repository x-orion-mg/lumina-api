<?php


namespace Lumina\ApiV2\Options\Settings;

use Lumina\ApiV2\Contracts\Registerable;
use Lumina\ApiV2\Core\Config;

class Api implements Registerable
{
    public static function register(): void
    {
        acf_add_local_field_group([

            'key' => 'group_lumina_settings_api',

            'title' => 'API',

            'fields' => [

                [
                    'key' => 'field_lumina_front_url',
                    'label' => 'URL du site Frontend',
                    'name' => 'frontend_url',
                    'type' => 'url',
                    'instructions' => 'URL du site Next.js ou frontend headless.',
                    'placeholder' => 'https://www.example.com',
                    'required' => 0,
                ],
                [
                    'key' => 'field_lumina_login_page_url',
                    'label' => 'URL page de connexion',
                    'name' => 'login_page_url',
                    'type' => 'url',
                    'instructions' => 'Lien vers la page de connexion du frontend (ex: Next.js).',
                    'placeholder' => 'https://frontend.com/login',
                ],

                [
                    'key' => 'field_lumina_password_reset_url',
                    'label' => 'URL modification du mot de passe',
                    'name' => 'password_reset_url',
                    'type' => 'url',
                    'instructions' => 'Lien vers la page frontend permettant de définir un nouveau mot de passe.',
                    'placeholder' => 'https://frontend.com/reset-password',
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