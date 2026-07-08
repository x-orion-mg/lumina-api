<?php


namespace Lumina\ApiV2\Core;

use Lumina\ApiV2\Controllers\ContentController;
use Lumina\ApiV2\Controllers\IconController;
use Lumina\ApiV2\Controllers\LayoutController;
use Lumina\ApiV2\Controllers\OthersController;
use Lumina\ApiV2\Controllers\PageController;

class Router
{
    public static function registerRoutes()
    {
        // {lang} : codes WPML (fr, en, pt-br, zh-hans, …)
        $langPattern = '(?P<lang>[a-z0-9_-]{2,24})';

        register_rest_route(
            Config::API_NAMESPACE,
            '/' . $langPattern . '/page/(?P<slug>[a-zA-Z0-9-]+)',
            [
                'methods'  => 'GET',
                'callback' => [new PageController(), 'show'],
                'permission_callback' => '__return_true',
            ]
        );

        register_rest_route(
            Config::API_NAMESPACE,
            '/' . $langPattern . '/layout/header',
            [
                'methods'  => 'GET',
                'callback' => [new LayoutController(), 'header'],
                'permission_callback' => '__return_true',
            ]
        );

        register_rest_route(
            Config::API_NAMESPACE,
            '/' . $langPattern . '/layout/footer',
            [
                'methods'  => 'GET',
                'callback' => [new LayoutController(), 'footer'],
                'permission_callback' => '__return_true',
            ]
        );

        register_rest_route(
            Config::API_NAMESPACE,
            '/' . $langPattern . '/layout/others',
            [
                'methods'  => 'GET',
                'callback' => [new OthersController(), 'index'],
                'permission_callback' => '__return_true',
                'args' => [
                    'type' => [
                        'type'              => 'string',
                        'required'          => false,
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
            ]
        );

        register_rest_route(
            Config::API_NAMESPACE,
            '/icons',
            [
                'methods'  => 'GET',
                'callback' => [new IconController(), 'index'],
                'permission_callback' => '__return_true',
                'args' => [
                    'search' => [
                        'type'              => 'string',
                        'required'          => false,
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
            ]
        );

        register_rest_route(
            Config::API_NAMESPACE,
            '/icons/(?P<slug>[a-z0-9_-]+)',
            [
                'methods'  => 'GET',
                'callback' => [new IconController(), 'show'],
                'permission_callback' => '__return_true',
            ]
        );

        register_rest_route(
            Config::API_NAMESPACE,
            '/content-types',
            [
                'methods'  => 'GET',
                'callback' => [new ContentController(), 'types'],
                'permission_callback' => '__return_true',
            ]
        );

        register_rest_route(
            Config::API_NAMESPACE,
            '/' . $langPattern . '/content/(?P<post_type>[a-z0-9_-]+)',
            [
                'methods'  => 'GET',
                'callback' => [new ContentController(), 'index'],
                'permission_callback' => '__return_true',
                'args' => [
                    'search' => [
                        'type'              => 'string',
                        'required'          => false,
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'page' => [
                        'type'    => 'integer',
                        'default' => 1,
                        'minimum' => 1,
                    ],
                    'per_page' => [
                        'type'    => 'integer',
                        'default' => 20,
                        'minimum' => 1,
                        'maximum' => 100,
                    ],
                ],
            ]
        );

        register_rest_route(
            Config::API_NAMESPACE,
            '/' . $langPattern . '/content/(?P<post_type>[a-z0-9_-]+)/(?P<slug>[a-zA-Z0-9_-]+)',
            [
                'methods'  => 'GET',
                'callback' => [new ContentController(), 'show'],
                'permission_callback' => '__return_true',
            ]
        );
    }
}