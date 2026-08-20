<?php

namespace Lumina\ApiV2\PostTypes\Definitions\Event;

use Lumina\ApiV2\PostTypes\Contracts\PostTypeDefinitionProvider;
use Lumina\ApiV2\PostTypes\PostTypeDefinition;

class Definition implements PostTypeDefinitionProvider
{
    public static function create(): PostTypeDefinition
    {
        return PostTypeDefinition::fromArray([
            'key'             => 'event',
            'labels'          => [
                'name'          => 'Événements',
                'singular_name' => 'Événement',
            ],
            'slug'            => 'events',
            'icon'            => 'dashicons-calendar-alt',
            'supports'        => ['title', 'editor', 'thumbnail', 'excerpt'],
            'public'          => true,
            'show_ui'         => true,
            'show_in_rest'    => false,
            'has_archive'     => true,
            'default_enabled' => false,
            'api'             => ['enabled' => true],
            'description'     => 'Exemple de référence pour ajouter un nouveau Post Type.',
        ]);
    }
}
