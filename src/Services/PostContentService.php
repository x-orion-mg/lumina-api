<?php

namespace Lumina\ApiV2\Services;

use Lumina\ApiV2\Transformers\PostContentTransformer;

class PostContentService
{
    /**
     * @return array{items: array<int, array<string, mixed>>, pagination: array<string, int>, filters: array<string, mixed>}
     */
    public static function list(string $postType, string $lang, array $args = []): array
    {
        if (!ContentTypeService::isExposed($postType)) {
            return [
                'items'      => [],
                'pagination' => self::emptyPagination($args),
                'filters'    => ['post_type' => $postType, 'search' => $args['search'] ?? null],
            ];
        }

        $lang = LanguageService::normalizeFromRequest($lang);

        return LanguageService::runWithLanguage($lang, function () use ($postType, $lang, $args) {
            $page = max(1, (int) ($args['page'] ?? 1));
            $perPage = min(100, max(1, (int) ($args['per_page'] ?? 20)));
            $search = isset($args['search']) ? trim((string) $args['search']) : '';

            $queryArgs = [
                'post_type'              => $postType,
                'post_status'            => 'publish',
                'posts_per_page'         => $perPage,
                'paged'                  => $page,
                'orderby'                => 'date',
                'order'                  => 'DESC',
                'ignore_sticky_posts'    => true,
                'suppress_filters'       => false,
            ];

            if ($search !== '') {
                $queryArgs['s'] = $search;
            }

            $query = new \WP_Query($queryArgs);
            $items = [];

            foreach ($query->posts as $post) {
                if ($post instanceof \WP_Post) {
                    $items[] = PostContentTransformer::summary($post, $lang);
                }
            }

            return [
                'items'      => $items,
                'pagination' => [
                    'page'        => $page,
                    'per_page'    => $perPage,
                    'total'       => (int) $query->found_posts,
                    'total_pages' => (int) $query->max_num_pages,
                ],
                'filters'    => [
                    'post_type' => $postType,
                    'search'    => $search !== '' ? $search : null,
                    'lang'      => $lang,
                ],
            ];
        });
    }

    public static function getBySlug(string $postType, string $slug, ?string $lang = null): ?array
    {
        if (!ContentTypeService::isExposed($postType)) {
            return null;
        }

        $lang = LanguageService::normalizeFromRequest($lang);

        return LanguageService::runWithLanguage($lang, function () use ($postType, $slug, $lang) {
            $posts = get_posts([
                'name'           => $slug,
                'post_type'      => $postType,
                'post_status'    => 'publish',
                'posts_per_page' => 1,
                'suppress_filters' => false,
            ]);

            $post = $posts[0] ?? null;

            if (!$post instanceof \WP_Post) {
                return null;
            }

            $post = self::ensurePostInLanguage($post, $lang);

            if (!$post instanceof \WP_Post) {
                return null;
            }

            return PostContentTransformer::detail($post, $lang);
        });
    }

    private static function ensurePostInLanguage(\WP_Post $post, string $lang): ?\WP_Post
    {
        if (!LanguageService::isWpmlActive()) {
            return $post;
        }

        $postLang = LanguageService::postLanguageCode((int) $post->ID);

        if ($postLang !== null && strcasecmp($postLang, $lang) === 0) {
            return $post;
        }

        $translatedId = LanguageService::translatedObjectId((int) $post->ID, $lang, $post->post_type);

        if ($translatedId === null) {
            return $postLang === null ? $post : null;
        }

        if ($translatedId === (int) $post->ID) {
            return $post;
        }

        $translated = get_post($translatedId);

        if (!$translated instanceof \WP_Post || $translated->post_type !== $post->post_type) {
            return null;
        }

        return $translated;
    }

    /**
     * @param array<string, mixed> $args
     * @return array<string, int>
     */
    private static function emptyPagination(array $args): array
    {
        return [
            'page'        => max(1, (int) ($args['page'] ?? 1)),
            'per_page'    => max(1, (int) ($args['per_page'] ?? 20)),
            'total'       => 0,
            'total_pages' => 0,
        ];
    }
}
