<?php

namespace Lumina\ApiV2\Blocks;

class TransformerRegistry
{
    /** @var array<string, class-string>|null blockName => Transformer class */
    private static ?array $map = null;

    /**
     * @return array<string, class-string>
     */
    public static function all(): array
    {
        if (self::$map === null) {
            self::$map = self::discover();
        }

        return self::$map;
    }

    private static function discover(): array
    {
        $map = [];

        foreach (glob(__DIR__ . '/*', GLOB_ONLYDIR) as $dir) {
            $configFile = $dir . '/config.php';
            $transformerFile = $dir . '/Transformer.php';

            if (!file_exists($configFile) || !file_exists($transformerFile)) {
                continue;
            }

            $config = include $configFile;
            $acfName = $config['name'] ?? null;

            if (!$acfName) {
                continue;
            }

            $folder = basename($dir);
            $classBase = str_replace(' ', '', ucwords(str_replace('-', ' ', $folder)));
            $class = 'Lumina\\ApiV2\\Blocks\\' . $classBase . '\\Transformer';

            if (!class_exists($class)) {
                require_once $transformerFile;
            }

            if (!class_exists($class) || !method_exists($class, 'transform')) {
                continue;
            }

            $map['acf/' . $acfName] = $class;
        }

        return $map;
    }
}
