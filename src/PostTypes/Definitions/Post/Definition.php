<?php

namespace Lumina\ApiV2\PostTypes\Definitions\Post;

use Lumina\ApiV2\PostTypes\Contracts\PostTypeDefinitionProvider;
use Lumina\ApiV2\PostTypes\PostTypeDefinition;

class Definition implements PostTypeDefinitionProvider
{
    public static function create(): PostTypeDefinition
    {
        return PostTypeDefinition::fromArray([
            'key'             => 'post',
            'builtin'         => true,
            'managed'         => false,
            'default_enabled' => true,
            'labels'          => [
                'name'          => 'Articles',
                'singular_name' => 'Article',
            ],
            'slug'            => 'post',
            'supports'        => ['title', 'editor', 'thumbnail', 'excerpt', 'author'],
            'api'             => ['enabled' => true],
            'description'     => 'Articles WordPress natifs.',
        ]);
    }
}
