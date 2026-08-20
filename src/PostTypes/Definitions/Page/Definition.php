<?php

namespace Lumina\ApiV2\PostTypes\Definitions\Page;

use Lumina\ApiV2\PostTypes\Contracts\PostTypeDefinitionProvider;
use Lumina\ApiV2\PostTypes\PostTypeDefinition;

class Definition implements PostTypeDefinitionProvider
{
    public static function create(): PostTypeDefinition
    {
        return PostTypeDefinition::fromArray([
            'key'             => 'page',
            'builtin'         => true,
            'managed'         => false,
            'default_enabled' => true,
            'labels'          => [
                'name'          => 'Pages',
                'singular_name' => 'Page',
            ],
            'slug'            => 'page',
            'supports'        => ['title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'],
            'api'             => ['enabled' => true],
            'description'     => 'Pages WordPress natives (Gutenberg).',
        ]);
    }
}
