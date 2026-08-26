<?php

namespace Lumina\ApiV2\PostTypes\Definitions\Brands;

use Lumina\ApiV2\PostTypes\Contracts\PostTypeDefinitionProvider;
use Lumina\ApiV2\PostTypes\PostTypeDefinition;

class Definition implements PostTypeDefinitionProvider
{
    public static function create(): PostTypeDefinition
    {
        return PostTypeDefinition::fromArray([
            'key'             => 'brand',
            'managed'         => true,
            'labels'          => [
                'name'          => 'Marques',
                'singular_name' => 'Marque',
            ],
            'slug'            => 'brand',
            'icon'            => 'dashicons-share-alt',
            'supports'        => ['title', 'editor', 'thumbnail'],
            'public'          => true,
            'show_ui'         => true,
            'show_in_rest'    => false,
            'default_enabled' => true,
            'api'             => ['enabled' => true],
            'description'     => 'Marques (CPT enregistré par le thème si présent).',
        ]);
    }
}
