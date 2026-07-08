<?php

namespace Lumina\ApiV2\Services;

use Lumina\ApiV2\Acf\IconRegistry;

class IconService
{
    /**
     * @return array{items: array<int, array<string, mixed>>, total: int, search: string|null}
     */
    public static function list(?string $search = null): array
    {
        $items = array_values(IconRegistry::all());
        $search = self::normalizeSearch($search);

        if ($search !== null) {
            $items = array_values(array_filter($items, static function (array $icon) use ($search): bool {
                $haystack = mb_strtolower($icon['slug'] . ' ' . $icon['label']);

                return mb_strpos($haystack, $search) !== false;
            }));
        }

        return [
            'items'  => $items,
            'total'  => count($items),
            'search' => $search,
        ];
    }

    public static function getBySlug(string $slug): ?array
    {
        return IconRegistry::resolve($slug);
    }

    private static function normalizeSearch(?string $search): ?string
    {
        if ($search === null) {
            return null;
        }

        $search = trim(mb_strtolower($search));

        return $search !== '' ? $search : null;
    }
}
