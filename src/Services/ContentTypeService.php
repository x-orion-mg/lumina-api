<?php

namespace Lumina\ApiV2\Services;

class ContentTypeService
{
    /**
     * Types de contenus exposés par l’API (filtrables).
     *
     * @return array<string, array{label: string, rest_base: string, hierarchical: bool}>
     */
    public static function exposedTypes(): array
    {
        $defaults = [
            'page'            => ['label' => 'Pages'],
            'post'            => ['label' => 'Articles'],
            'partner'         => ['label' => 'Partenaires'],
            'testimony'       => ['label' => 'Témoignages'],
            'solution'        => ['label' => 'Solutions'],
            'type-beagile'    => ['label' => 'Types Be Agile'],
            'type-be-inspired'=> ['label' => 'Types Be Inspired'],
            'actualite'       => ['label' => 'Actualités'],
        ];

        /** @var array<string, array{label?: string}> $types */
        $types = apply_filters('lumina_api_v2_exposed_post_types', $defaults);

        $out = [];

        foreach ($types as $slug => $meta) {
            if (!self::isAllowedPostType($slug)) {
                continue;
            }

            $object = get_post_type_object($slug);

            if (!$object) {
                continue;
            }

            $out[] = [
                'slug'          => $slug,
                'label'         => $meta['label'] ?? $object->labels->name ?? $slug,
                'hierarchical'  => (bool) $object->hierarchical,
                'rest_base'     => $object->rest_base ?? $slug,
                'has_archive'   => (bool) $object->has_archive,
            ];
        }

        return $out;
    }

    public static function isExposed(string $postType): bool
    {
        foreach (self::exposedTypes() as $type) {
            if ($type['slug'] === $postType) {
                return true;
            }
        }

        return false;
    }

    private static function isAllowedPostType(string $slug): bool
    {
        $object = get_post_type_object($slug);

        return $object instanceof \WP_Post_Type && $object->public;
    }
}
