<?php

namespace Lumina\ApiV2\Services;

class MetaService
{
    /**
     * Métadonnées SEO (Yoast) pour une page / un post.
     * Réutilise CMetaData du thème si disponible, sinon Yoast directement.
     */
    public static function forPost(int $postId): array
    {
        if (class_exists('CMetaData', false)) {
            return \CMetaData::get_metadata_post_id($postId);
        }

        return self::fromYoast($postId);
    }

    private static function fromYoast(int $postId): array
    {
        if (!function_exists('YoastSEO')) {
            return [];
        }

        $yoast = YoastSEO()->meta->for_post($postId);

        if (!$yoast) {
            return [];
        }

        $canonical = $yoast->canonical ?? '';

        return [
            'title'                 => $yoast->title ?? '',
            'breadcrumbs'           => $yoast->breadcrumbs ?? [],
            'canonical'             => $canonical ? str_replace(site_url(), '', $canonical) : '',
            'meta_description'      => $yoast->meta_description ?? '',
            'indexable'             => $yoast->indexable ?? null,
            'og_article_author'     => $yoast->open_graph_article_author ?? '',
            'company_name'          => $yoast->company_name ?? '',
            'robots'                => $yoast->robots ?? [],
            'og_locale'             => $yoast->open_graph_locale ?? '',
            'og_type'               => $yoast->open_graph_type ?? '',
            'og_title'              => !empty($yoast->open_graph_title)
                ? str_replace(site_url(), '', $yoast->open_graph_title)
                : '',
            'og_description'        => $yoast->open_graph_description ?? '',
            'og_url'                => apply_filters('skeem_api_link', $yoast->open_graph_url ?? ''),
            'og_site_name'          => $yoast->open_graph_site_name ?? '',
            'og_enabled'            => $yoast->open_graph_enabled ?? false,
            'rel_next'              => $yoast->rel_next ?? '',
            'rel_prev'              => $yoast->rel_prev ?? '',
            'article_modified_time' => $yoast->open_graph_article_modified_time ?? '',
            'twitter_card'          => $yoast->twitter_card ?? '',
            'og_image'              => $yoast->open_graph_images ?? [],
            'schema'                => $yoast->schema ?? [],
            'site_name'             => $yoast->site_name ?? '',
            'site_represents'       => $yoast->site_represents ?? false,
            'schema_page_type'      => $yoast->schema_page_type ?? [],
            'twitter_title'         => $yoast->twitter_title ?? '',
            'twitter_description'   => $yoast->twitter_description ?? '',
            'twitter_image'         => $yoast->twitter_image ?? '',
            'twitter_site'          => $yoast->twitter_site ?? '',
        ];
    }
}
