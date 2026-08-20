<?php

namespace Lumina\ApiV2\Services;

use Lumina\ApiV2\PostTypes\Api\PostTypeApiRegistry;

class ContentTypeService
{
    /**
     * Types de contenus exposés par l’API (filtrables).
     *
     * @return array<int, array<string, mixed>>
     */
    public static function exposedTypes(): array
    {
        return PostTypeApiRegistry::exposedTypes();
    }

    public static function isExposed(string $postType): bool
    {
        return PostTypeApiRegistry::isExposed($postType);
    }
}
