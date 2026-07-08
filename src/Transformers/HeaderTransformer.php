<?php

namespace Lumina\ApiV2\Transformers;

use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\Button;
use Lumina\ApiV2\Helpers\Icon;
use Lumina\ApiV2\Helpers\Media;

class HeaderTransformer
{
    /**
     * @param array<string, mixed> $data Champs options (header_*).
     */
    public static function transform(array $data, string $lang): array
    {
        return [
            'lang' => $lang,
            'logo' => Media::image($data['header_logo'] ?? null),
            'phone' => $data['header_phone'] ?? '',
            'cta' => Button::parse($data['header_cta'] ?? null),
            'show_language_switcher' => (bool) ($data['header_show_language_switcher'] ?? true),
            'navigation' => self::navigation($data['header_nav'] ?? []),
        ];
    }

    /**
     * @param mixed $items
     */
    private static function navigation($items): array
    {
        return AcfRepeater::parse($items, static function (array $item): array {
            $type = $item['type'] ?? 'link';

            $nav = [
                'type'  => $type,
                'label' => $item['label'] ?? '',
                'link'  => $type === 'link' ? Button::parse($item['link'] ?? null) : null,
            ];

            if ($type === 'mega_menu') {
                $nav['mega_menu'] = self::megaMenu($item['mega_menu'] ?? []);
            }

            return $nav;
        });
    }

    /**
     * @param array<string, mixed> $mega
     */
    private static function megaMenu(array $mega): array
    {
        return [
            'title' => $mega['title'] ?? '',
            'description' => $mega['description'] ?? '',
            'links' => AcfRepeater::parse(
                $mega['links'] ?? [],
                static fn(array $row): ?array => Button::parse($row['link'] ?? null)
            ),
            'highlights' => AcfRepeater::parse(
                $mega['highlights'] ?? [],
                static function (array $row): array {
                    return [
                        'icon' => Icon::parse($row['icon_lumina'] ?? null),
                        'title' => $row['title'] ?? '',
                        'description' => $row['description'] ?? '',
                        'link' => Button::parse($row['link'] ?? null),
                    ];
                }
            ),
        ];
    }
}
