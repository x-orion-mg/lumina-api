<?php

namespace Lumina\ApiV2\PostTypes;

class PostTypeRepository
{
    public const OPTION_KEY = 'lumina_api_v2_post_types';

    /** @var array<string, array{enabled: bool}>|null */
    private static ?array $cache = null;

    public static function isEnabled(string $key): bool
    {
        $all = self::getAll();

        if (!isset($all[$key])) {
            $definition = PostTypeRegistry::instance()->get($key);

            return $definition !== null ? $definition->isDefaultEnabled() : false;
        }

        return (bool) ($all[$key]['enabled'] ?? false);
    }

    public static function setEnabled(string $key, bool $enabled): void
    {
        if (self::$cache === null) {
            self::$cache = self::loadFromDatabase();
        }

        self::$cache[$key] = ['enabled' => $enabled];
    }

    /**
     * @return array<string, array{enabled: bool}>
     */
    public static function getAll(): array
    {
        if (self::$cache === null) {
            self::$cache = self::loadFromDatabase();
        }

        return self::$cache;
    }

    /**
     * @param array<string, array{enabled: bool}> $configuration
     */
    public static function save(array $configuration): void
    {
        $normalized = [];

        foreach ($configuration as $key => $settings) {
            if (!is_string($key) || $key === '') {
                continue;
            }

            $normalized[$key] = [
                'enabled' => (bool) ($settings['enabled'] ?? false),
            ];
        }

        update_option(self::OPTION_KEY, $normalized, false);
        self::$cache = $normalized;
    }

    public static function persist(): void
    {
        if (self::$cache !== null) {
            self::save(self::$cache);
        }
    }

    public static function flushCache(): void
    {
        self::$cache = null;
    }

    /**
     * Initialise les valeurs par défaut pour les définitions découvertes.
     */
    public static function ensureDefaults(PostTypeRegistry $registry): void
    {
        $stored = get_option(self::OPTION_KEY, []);
        $stored = is_array($stored) ? $stored : [];
        $changed = false;

        foreach ($registry->all() as $definition) {
            $key = $definition->getKey();

            if (!isset($stored[$key])) {
                $stored[$key] = [
                    'enabled' => $definition->isDefaultEnabled(),
                ];
                $changed = true;
            }
        }

        if ($changed || get_option(self::OPTION_KEY, null) === false) {
            self::save($stored);
        }
    }

    /**
     * @return array<string, array{enabled: bool}>
     */
    private static function loadFromDatabase(): array
    {
        $stored = get_option(self::OPTION_KEY, []);

        return is_array($stored) ? $stored : [];
    }
}
