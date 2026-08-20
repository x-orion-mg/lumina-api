<?php

namespace Lumina\ApiV2\PostTypes\Registration;

use Lumina\ApiV2\PostTypes\PostTypeDefinition;
use Lumina\ApiV2\PostTypes\PostTypeRegistry;

class PostTypeRegistrar
{
    public static function register(): void
    {
        $registry = PostTypeRegistry::instance();

        foreach ($registry->enabled() as $definition) {
            if (!self::shouldRegister($definition)) {
                continue;
            }

            self::registerDefinition($definition);
        }
    }

    /**
     * Le plugin n’enregistre un CPT que s’il est géré par Lumina et absent du système.
     */
    public static function shouldRegister(PostTypeDefinition $definition): bool
    {
        if ($definition->isBuiltin() || !$definition->isManaged()) {
            return false;
        }

        if (self::postTypeAlreadyExists($definition->getKey())) {
            return false;
        }

        /** @var bool $shouldRegister */
        $shouldRegister = apply_filters(
            'lumina_api_v2_post_type_should_register',
            true,
            $definition->getKey(),
            $definition
        );

        return (bool) $shouldRegister;
    }

    private static function registerDefinition(PostTypeDefinition $definition): void
    {
        $key = $definition->getKey();

        if (self::postTypeAlreadyExists($key)) {
            return;
        }

        $args = apply_filters(
            'lumina_api_v2_post_type_args',
            $definition->getRegisterArgs(),
            $key,
            $definition
        );

        register_post_type($key, $args);
    }

    /**
     * Vérifie si le post type est déjà enregistré (WordPress, thème, WooCommerce, autre plugin).
     */
    private static function postTypeAlreadyExists(string $key): bool
    {
        if ($key === '') {
            return true;
        }

        if (post_type_exists($key)) {
            return true;
        }

        return get_post_type_object($key) instanceof \WP_Post_Type;
    }
}
