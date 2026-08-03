<?php

namespace Lumina\ApiV2\Options;

use Lumina\ApiV2\Contracts\Registerable;

class Loader
{
    public static function init(): void
    {
        add_action('acf/init', [self::class, 'load']);
    }


    public static function load(): void
    {
        self::discover(__DIR__);
    }


    protected static function discover(string $directory): void
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory)
        );

        foreach ($iterator as $file) {

            if ($file->getFilename() === 'Loader.php') {
                continue;
            }

            if ($file->getExtension() !== 'php') {
                continue;
            }

            $relative = str_replace(
                [
                    __DIR__ . DIRECTORY_SEPARATOR,
                    '.php'
                ],
                '',
                $file->getPathname()
            );


            $class = __NAMESPACE__ . '\\' .
                str_replace(
                    DIRECTORY_SEPARATOR,
                    '\\',
                    $relative
                );


            if (!class_exists($class)) {
                continue;
            }


            if (!is_subclass_of($class, Registerable::class)) {
                continue;
            }


            $class::register();
        }
    }
}