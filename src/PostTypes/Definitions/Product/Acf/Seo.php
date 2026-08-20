<?php

namespace Lumina\ApiV2\PostTypes\Definitions\Product\Acf;

use Lumina\ApiV2\PostTypes\Acf\AcfGroup;

class Seo extends AcfGroup
{
    public static function key(): string
    {
        return 'group_lumina_product_seo';
    }

    public static function title(): string
    {
        return '[Produits -SEO ] - Informations';
    }

    public static function fields(): array
    {
        return [
            'acf_groups' => [
                \Lumina\ApiV2\PostTypes\Acf\Shared\Seo::class,
            ],
        ];
    }
}