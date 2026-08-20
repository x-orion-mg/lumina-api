<?php

namespace Lumina\ApiV2\PostTypes\Definitions\Solution;

use Lumina\ApiV2\PostTypes\Contracts\PostTypeDefinitionProvider;
use Lumina\ApiV2\PostTypes\PostTypeDefinition;

class Definition implements PostTypeDefinitionProvider
{
    public static function create(): PostTypeDefinition
    {
        return PostTypeDefinition::fromArray([
            'key'             => 'solution',
            'managed'         => true,
            'labels'          => [
                'name'          => 'Solutions',
                'singular_name' => 'Solution',
            ],
            'slug'            => 'solution',
            'icon'            => 'dashicons-lightbulb',
            'supports'        => ['title', 'editor', 'thumbnail', 'excerpt'],
            'public'          => true,
            'show_ui'         => true,
            'show_in_rest'    => false,
            'default_enabled' => true,
            'api'             => ['enabled' => true],
            'description'     => 'Solutions (CPT enregistré par le thème si présent).',
        ]);
    }
}
