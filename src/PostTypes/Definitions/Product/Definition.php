<?php

namespace Lumina\ApiV2\PostTypes\Definitions\Product;

use Lumina\ApiV2\PostTypes\Contracts\PostTypeDefinitionProvider;
use Lumina\ApiV2\PostTypes\PostTypeDefinition;

class Definition implements PostTypeDefinitionProvider
{
    public static function create(): PostTypeDefinition
    {
        return PostTypeDefinition::fromArray([
            'key'             => 'product',
            'managed'         => false,
            'labels'          => [
                'name'          => 'Produits',
                'singular_name' => 'Produit',
            ],
            'slug'            => 'product',
            'supports'        => [],
            'public'          => true,
            'default_enabled' => false,
            'api'             => ['enabled' => true],
            'description'     => 'Produits WooCommerce (CPT enregistré par WooCommerce).',
        ]);
    }
}
