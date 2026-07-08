<?php

namespace Lumina\ApiV2\Helpers;

use Lumina\ApiV2\Acf\IconRegistry;

class Icon
{
    /**
     * Normalise une valeur icon_lumina pour l'API.
     */
    public static function parse(?string $slug): ?array
    {
        return IconRegistry::resolve($slug);
    }
}
