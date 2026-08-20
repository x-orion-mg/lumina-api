<?php

namespace Lumina\ApiV2\PostTypes\Api;

use Lumina\ApiV2\PostTypes\PostTypeRegistry;

class PostTypeApiRegistry
{
    /**
     * Types exposés par l’API REST Lumina.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function exposedTypes(): array
    {
        $registry = PostTypeRegistry::instance();
        $items = [];

        foreach ($registry->all() as $definition) {
            $key = $definition->getKey();

            if (!self::isExposed($key)) {
                continue;
            }

            $object = get_post_type_object($key);
            $items[] = self::formatTypeItem($definition, $object);
        }

        return self::applyLegacyFilter($items);
    }

    public static function isExposed(string $postType): bool
    {
        $registry = PostTypeRegistry::instance();

        if (!$registry->has($postType)) {
            return self::isLegacyExposed($postType);
        }

        $definition = $registry->get($postType);

        if ($definition === null) {
            return false;
        }

        if (!$registry->isEnabled($postType)) {
            return false;
        }

        if (!$definition->isApiEnabled()) {
            return false;
        }

        return self::isAllowedPostType($postType);
    }

    /**
     * @param \WP_Post_Type|null $object
     * @return array<string, mixed>
     */
    private static function formatTypeItem($definition, $object): array
    {
        $key = $definition->getKey();

        return [
            'key'           => $key,
            'slug'          => $key,
            'rewrite_slug'  => $definition->getSlug(),
            'label'         => $definition->getLabel(),
            'api_enabled'   => $definition->isApiEnabled(),
            'hierarchical'  => $object instanceof \WP_Post_Type
                ? (bool) $object->hierarchical
                : $definition->isHierarchical(),
            'rest_base'     => $object instanceof \WP_Post_Type
                ? ($object->rest_base ?? $key)
                : $key,
            'has_archive'   => $object instanceof \WP_Post_Type
                ? (bool) $object->has_archive
                : $definition->hasArchive(),
            'builtin'       => $definition->isBuiltin(),
            'managed'       => $definition->isManaged(),
        ];
    }

    /**
     * Compatibilité avec le filtre legacy lumina_api_v2_exposed_post_types.
     *
     * @param array<int, array<string, mixed>> $items
     * @return array<int, array<string, mixed>>
     */
    private static function applyLegacyFilter(array $items): array
    {
        $legacyFormat = [];

        foreach ($items as $item) {
            $slug = $item['slug'] ?? $item['key'] ?? '';
            $legacyFormat[$slug] = ['label' => $item['label'] ?? $slug];
        }

        /** @var array<string, array{label?: string}> $filtered */
        $filtered = apply_filters('lumina_api_v2_exposed_post_types', $legacyFormat);

        if (!is_array($filtered)) {
            return $items;
        }

        $allowedSlugs = array_keys($filtered);
        $out = [];

        foreach ($items as $item) {
            $slug = $item['slug'] ?? '';

            if (in_array($slug, $allowedSlugs, true)) {
                if (isset($filtered[$slug]['label'])) {
                    $item['label'] = $filtered[$slug]['label'];
                }

                $out[] = $item;
            }
        }

        foreach ($filtered as $slug => $meta) {
            if (!is_string($slug) || $slug === '') {
                continue;
            }

            $alreadyIncluded = false;

            foreach ($out as $item) {
                if (($item['slug'] ?? '') === $slug) {
                    $alreadyIncluded = true;
                    break;
                }
            }

            if ($alreadyIncluded) {
                continue;
            }

            if (!self::isAllowedPostType($slug)) {
                continue;
            }

            $object = get_post_type_object($slug);

            if (!$object instanceof \WP_Post_Type) {
                continue;
            }

            $out[] = [
                'key'          => $slug,
                'slug'         => $slug,
                'rewrite_slug' => $slug,
                'label'        => $meta['label'] ?? $object->labels->name ?? $slug,
                'api_enabled'  => true,
                'hierarchical' => (bool) $object->hierarchical,
                'rest_base'    => $object->rest_base ?? $slug,
                'has_archive'  => (bool) $object->has_archive,
                'builtin'      => in_array($slug, ['page', 'post'], true),
                'managed'      => false,
            ];
        }

        return $out;
    }

    private static function isLegacyExposed(string $postType): bool
    {
        $legacyDefaults = [
            'page'             => ['label' => 'Pages'],
            'post'             => ['label' => 'Articles'],
            'partner'          => ['label' => 'Partenaires'],
            'testimony'        => ['label' => 'Témoignages'],
            'solution'         => ['label' => 'Solutions'],
            'type-beagile'     => ['label' => 'Types Be Agile'],
            'type-be-inspired' => ['label' => 'Types Be Inspired'],
            'actualite'        => ['label' => 'Actualités'],
        ];

        /** @var array<string, array{label?: string}> $filtered */
        $filtered = apply_filters('lumina_api_v2_exposed_post_types', $legacyDefaults);

        if (!isset($filtered[$postType])) {
            return false;
        }

        return self::isAllowedPostType($postType);
    }

    private static function isAllowedPostType(string $slug): bool
    {
        $object = get_post_type_object($slug);

        return $object instanceof \WP_Post_Type && $object->public;
    }
}
