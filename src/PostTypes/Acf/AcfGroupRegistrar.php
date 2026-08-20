<?php

namespace Lumina\ApiV2\PostTypes\Acf;

class AcfGroupRegistrar
{
    public static function registerAll(): void
    {
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }

        $registry = AcfRegistry::instance();

        $registry->discover();

        foreach ($registry->active() as $group) {
            self::registerGroup($registry, $group);
        }
    }

    /**
     * @param array{
     *     class: class-string<AcfGroup>,
     *     post_types: array<string, bool>
     * } $group
     */
    private static function registerGroup(
        AcfRegistry $registry,
        array $group
    ): void {
        $config = $registry->buildGroupConfig($group);

        if (
            empty($config['key'])
            || empty($config['fields'])
            || !is_array($config['fields'])
        ) {
            return;
        }

        $postTypes = array_keys($group['post_types']);

        $config['fields'] = apply_filters(
            'lumina_api_v2_acf_fields',
            $config['fields'],
            $config['key'],
            $postTypes,
            $group['class']
        );

        /*
         * Compatibilité avec le filtre historique.
         *
         * Le filtre est appliqué pour chaque Post Type concerné.
         * Le résultat final est fusionné.
         */
        foreach ($postTypes as $postType) {
            $definition = \Lumina\ApiV2\PostTypes\PostTypeRegistry::instance()
                ->get($postType);

            if (!$definition) {
                continue;
            }

            $config['fields'] = apply_filters(
                'lumina_api_v2_post_type_fields',
                $config['fields'],
                $postType,
                $definition
            );
        }

        if (!is_array($config['fields']) || $config['fields'] === []) {
            return;
        }

        $config = apply_filters(
            'lumina_api_v2_acf_field_group',
            $config,
            $group['class'],
            $postTypes
        );

        acf_add_local_field_group($config);
    }
}