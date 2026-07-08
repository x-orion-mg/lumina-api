<?php

namespace Lumina\ApiV2\Transformers;

use Lumina\ApiV2\Helpers\AcfFields;
use Lumina\ApiV2\Helpers\Media;
use Lumina\ApiV2\Helpers\MultilingualSlug;
use Lumina\ApiV2\Helpers\Wysiwyg;
use Lumina\ApiV2\Services\MetaService;

class PostContentTransformer
{
    /**
     * Liste légère (sans contenu complet).
     */
    public static function summary(\WP_Post $post, string $lang): array
    {
        return [
            'id'              => (int) $post->ID,
            'post_type'       => $post->post_type,
            'title'           => get_the_title($post),
            'slug'            => MultilingualSlug::getAllTranslationsSlugs((int) $post->ID, $lang, $post->post_type),
            'lang'            => $lang,
            'excerpt'         => self::excerpt($post),
            'featured_image'  => Media::image(get_post_thumbnail_id($post->ID) ?: null),
            'date'            => get_the_date('c', $post),
            'modified'        => get_the_modified_date('c', $post),
        ];
    }

    /**
     * Détail complet : blocks Gutenberg, WYSIWYG et/ou ACF.
     */
    public static function detail(\WP_Post $post, string $lang): array
    {
        $blocks = self::hasGutenbergBlocks($post->post_content)
            ? BlocksTransformer::transform($post->post_content)
            : [];

        $wysiwyg = '';

        if (trim(strip_tags($post->post_content)) !== '') {
            $wysiwyg = Wysiwyg::parse($post->post_content);
        }

        $acf = function_exists('get_fields')
            ? AcfFields::normalize(get_fields($post->ID) ?: [])
            : [];

        $contentMode = self::resolveContentMode($blocks, $wysiwyg, $acf);

        return [
            'id'              => (int) $post->ID,
            'post_type'       => $post->post_type,
            'title'           => get_the_title($post),
            'slug'            => MultilingualSlug::getAllTranslationsSlugs((int) $post->ID, $lang, $post->post_type),
            'lang'            => $lang,
            'excerpt'         => self::excerpt($post),
            'featured_image'  => Media::image(get_post_thumbnail_id($post->ID) ?: null),
            'date'            => get_the_date('c', $post),
            'modified'        => get_the_modified_date('c', $post),
            'content_mode'    => $contentMode,
            'blocks'          => $blocks,
            'content'         => $wysiwyg,
            'acf'             => $acf,
            'meta_data'       => MetaService::forPost((int) $post->ID),
        ];
    }

    private static function excerpt(\WP_Post $post): string
    {
        if ($post->post_excerpt !== '') {
            return $post->post_excerpt;
        }

        return wp_trim_words(wp_strip_all_tags($post->post_content), 40, '…');
    }

    private static function hasGutenbergBlocks(string $content): bool
    {
        foreach (parse_blocks($content) as $block) {
            if (!empty($block['blockName'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array<int, mixed> $blocks
     * @param array<string, mixed> $acf
     */
    private static function resolveContentMode(array $blocks, string $wysiwyg, array $acf): string
    {
        $hasBlocks = $blocks !== [];
        $hasWysiwyg = $wysiwyg !== '';
        $hasAcf = $acf !== [];

        if ($hasBlocks && ($hasWysiwyg || $hasAcf)) {
            return 'mixed';
        }

        if ($hasBlocks) {
            return 'blocks';
        }

        if ($hasWysiwyg) {
            return 'wysiwyg';
        }

        if ($hasAcf) {
            return 'acf';
        }

        return 'empty';
    }
}
