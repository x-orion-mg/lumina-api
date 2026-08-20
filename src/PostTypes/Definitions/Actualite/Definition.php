<?php

namespace Lumina\ApiV2\PostTypes\Definitions\Actualite;

use Lumina\ApiV2\PostTypes\Contracts\PostTypeDefinitionProvider;
use Lumina\ApiV2\PostTypes\PostTypeDefinition;

class Definition implements PostTypeDefinitionProvider
{
    public static function create(): PostTypeDefinition
    {
        return PostTypeDefinition::fromArray([
            'key'             => 'actualite',
            'managed'         => true,
            'labels'          => [
                'name'          => 'Actualités',
                'singular_name' => 'Actualité',
            ],
            'slug'            => 'actualite',
            'icon'            => 'dashicons-megaphone',
            'supports'        => ['title', 'editor', 'thumbnail', 'excerpt'],
            'public'          => true,
            'show_ui'         => true,
            'show_in_rest'    => false,
            'has_archive'     => true,
            'default_enabled' => true,
            'api'             => ['enabled' => true],
            'description'     => 'Actualités (CPT enregistré par le thème si présent).',
        ]);
    }
}
