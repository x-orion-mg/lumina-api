<?php

namespace Lumina\ApiV2\Helpers;

/**
 * Helpers chaîne compatibles PHP 7.4–8.x (équivalents str_starts_with / str_contains).
 */
class Str
{
    public static function startsWith(string $haystack, string $needle): bool
    {
        if ($needle === '') {
            return true;
        }

        return strncmp($haystack, $needle, strlen($needle)) === 0;
    }

    public static function contains(string $haystack, string $needle): bool
    {
        if ($needle === '') {
            return true;
        }

        return strpos($haystack, $needle) !== false;
    }
}
