<?php

namespace Lumina\ApiV2\Helpers;

class AcfBlockData
{
    /**
     * Extrait les champs ACF d'un block Gutenberg (sans clés internes _field).
     */
    public static function extract(array $block): array
    {
        $data = $block['attrs']['data'] ?? [];

        return array_filter(
            $data,
            static fn(string $key): bool => $key[0] !== '_',
            ARRAY_FILTER_USE_KEY
        );
    }
}
