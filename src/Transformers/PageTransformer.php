<?php


namespace Lumina\ApiV2\Transformers;

use Lumina\ApiV2\Helpers\MultilingualSlug;
use Lumina\ApiV2\Services\MetaService;

class PageTransformer
{
    public static function transform($page, string $lang)
    {
        return [
            'id' => $page->ID,
            'title' => get_the_title($page->ID),
            'slug' => MultilingualSlug::getAllTranslationsSlugs((int) $page->ID, $lang, 'page'),
            'lang' => $lang,

            // ACF
            'acf' => get_fields($page->ID),

            // Gutenberg (données normalisées pour l'API)
            'blocks' => BlocksTransformer::transform($page->post_content),

            // SEO (Yoast)
            'meta_data' => MetaService::forPost((int) $page->ID),
        ];
    }
}