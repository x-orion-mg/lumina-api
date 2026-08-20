<?php

namespace Lumina\ApiV2\PostTypes\Definitions\Testimony;

use Lumina\ApiV2\PostTypes\Contracts\PostTypeDefinitionProvider;
use Lumina\ApiV2\PostTypes\PostTypeDefinition;

class Definition implements PostTypeDefinitionProvider
{
    public static function create(): PostTypeDefinition
    {
        return PostTypeDefinition::fromArray([
            'key'             => 'testimony',
            'managed'         => true,
            'labels'          => [
                'name'          => 'Témoignages',
                'singular_name' => 'Témoignage',
            ],
            'slug'            => 'testimony',
            'icon'            => 'dashicons-format-quote',
            'supports'        => ['title', 'editor', 'thumbnail'],
            'public'          => true,
            'show_ui'         => true,
            'show_in_rest'    => false,
            'default_enabled' => true,
            'api'             => ['enabled' => true],
            'description'     => 'Témoignages (CPT enregistré par le thème si présent).',
        ]);
    }
}
