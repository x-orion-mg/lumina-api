<?php

namespace Lumina\ApiV2\PostTypes\Definitions\Partner;

use Lumina\ApiV2\PostTypes\Contracts\PostTypeDefinitionProvider;
use Lumina\ApiV2\PostTypes\PostTypeDefinition;

class Definition implements PostTypeDefinitionProvider
{
    public static function create(): PostTypeDefinition
    {
        return PostTypeDefinition::fromArray([
            'key'             => 'partner',
            'managed'         => true,
            'labels'          => [
                'name'          => 'Partenaires',
                'singular_name' => 'Partenaire',
            ],
            'slug'            => 'partner',
            'icon'            => 'dashicons-businessperson',
            'supports'        => ['title', 'editor', 'thumbnail'],
            'public'          => true,
            'show_ui'         => true,
            'show_in_rest'    => false,
            'default_enabled' => true,
            'api'             => ['enabled' => true],
            'description'     => 'Partenaires (CPT enregistré par le thème si présent).',
        ]);
    }
}
