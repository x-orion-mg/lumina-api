<?php

namespace Lumina\ApiV2\PostTypes\Acf;

use Lumina\ApiV2\PostTypes\PostTypeDefinition;
use Lumina\ApiV2\PostTypes\PostTypeRegistry;

class AcfGroupRegistrar
{
    public static function registerAll(): void
    {
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }

        $registry = PostTypeRegistry::instance();

        foreach ($registry->all() as $definition) {
            if ($definition->isBuiltin()) {
                continue;
            }

            if (!self::shouldRegisterFields($definition)) {
                continue;
            }

            self::registerForDefinition($definition);
        }
    }

    /**
     * CPT géré ailleurs (WooCommerce, thème) : champs ACF dès que le post type existe.
     * CPT Lumina : champs ACF si activé dans l’admin Post Types.
     */
    public static function shouldRegisterFields(PostTypeDefinition $definition): bool
    {
        $registry = PostTypeRegistry::instance();
        $key = $definition->getKey();

        if ($registry->getFieldsClass($key) === null) {
            return false;
        }

        if (!$definition->isManaged() && post_type_exists($key)) {
            return true;
        }

        return $registry->isEnabled($key);
    }

    public static function registerForDefinition(PostTypeDefinition $definition): void
    {
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }

        $registry = PostTypeRegistry::instance();
        $key = $definition->getKey();
        $fieldsClass = $registry->getFieldsClass($key);

        if ($fieldsClass === null || !method_exists($fieldsClass, 'fields')) {
            return;
        }

        $fields = $fieldsClass::fields();
        $fields = apply_filters('lumina_api_v2_post_type_fields', $fields, $key, $definition);

        if (!is_array($fields) || $fields === []) {
            return;
        }

        $labels = $definition->getLabels();
        $singular = $labels['singular_name'] ?? $definition->getLabel();

        acf_add_local_field_group([
            'key'                   => self::groupKey($key),
            'title'                 => $singular . ' — Lumina API v2',
            'fields'                => $fields,
            'location'              => [
                [
                    [
                        'param'    => 'post_type',
                        'operator' => '==',
                        'value'    => $key,
                    ],
                ],
            ],
            'menu_order'            => 0,
            'position'              => 'normal',
            'style'                 => 'default',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'active'                => true,
        ]);
    }

    public static function groupKey(string $postTypeKey): string
    {
        return 'group_lumina_pt_' . sanitize_key($postTypeKey);
    }
}
