<?php

namespace Lumina\ApiV2\PostTypes\Acf\Shared;

use Lumina\ApiV2\PostTypes\Acf\AcfGroup;

class Seo extends AcfGroup
{
    public static function key(): string
    {
        return 'group_lumina_shared_seo';
    }

    public static function title(): string
    {
        return 'SEO';
    }

    public static function fields(): array
    {
        return [
            [
                'key' => 'field_lumina_shared_seo_title',
                'label' => 'Titre SEO',
                'name' => 'seo_title',
                'type' => 'text',
            ],

            [
                'key' => 'field_lumina_shared_seo_description',
                'label' => 'Description SEO',
                'name' => 'seo_description',
                'type' => 'textarea',
                'rows' => 4,
            ],

            [
                'key' => 'field_lumina_shared_seo_image',
                'label' => 'Image SEO',
                'name' => 'seo_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ],
        ];
    }
}