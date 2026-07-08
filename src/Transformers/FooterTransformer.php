<?php

namespace Lumina\ApiV2\Transformers;

use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\Button;
use Lumina\ApiV2\Helpers\Media;

class FooterTransformer
{
    /**
     * @param array<string, mixed> $data Champs options (footer_*).
     */
    public static function transform(array $data, string $lang): array
    {
        return [
            'lang' => $lang,
            'branding' => [
                'logo' => Media::image($data['footer_logo'] ?? null),
                'description' => $data['footer_description'] ?? '',
            ],
            'columns' => self::columns($data['footer_columns'] ?? []),
            'bottom' => [
                'copyright' => $data['footer_copyright'] ?? '',
                'legal_links' => self::legalLinks($data['footer_legal_links'] ?? []),
                'social_links' => self::socialLinks($data['footer_social_links'] ?? []),
            ],
        ];
    }

    /**
     * @param mixed $columns
     */
    private static function columns($columns): array
    {
        return AcfRepeater::parse($columns, static function (array $column): array {
            $type = $column['type'] ?? 'links';

            $out = [
                'title' => $column['title'] ?? '',
                'type'  => $type,
            ];

            if ($type === 'certifications') {
                $out['certifications'] = self::certifications($column['certifications'] ?? []);

                return $out;
            }

            $out['links'] = AcfRepeater::parse(
                $column['links'] ?? [],
                static fn(array $row): ?array => Button::parse($row['link'] ?? null)
            );

            return $out;
        });
    }

    /**
     * @param mixed $items
     */
    private static function certifications($items): array
    {
        return AcfRepeater::parse($items, static function (array $item): array {
            return [
                'label' => $item['label'] ?? '',
                'badge' => Media::image($item['badge'] ?? null),
            ];
        });
    }

    /**
     * @param mixed $items
     */
    private static function legalLinks($items): array
    {
        return AcfRepeater::parse(
            $items,
            static fn(array $row): ?array => Button::parse($row['link'] ?? null)
        );
    }

    /**
     * @param mixed $items
     */
    private static function socialLinks($items): array
    {
        return AcfRepeater::parse($items, static function (array $item): ?array {
            $url = trim((string) ($item['url'] ?? ''));

            if ($url === '') {
                return null;
            }

            $platform = (string) ($item['platform'] ?? '');

            return [
                'platform' => $platform,
                'label'    => self::socialLabel($platform),
                'url'      => $url,
                'target'   => '_blank',
            ];
        });
    }

    private static function socialLabel(string $platform): string
    {
        switch ($platform) {
            case 'linkedin':
                return 'LinkedIn';
            case 'twitter':
                return 'X';
            case 'youtube':
                return 'YouTube';
            case 'facebook':
                return 'Facebook';
            case 'instagram':
                return 'Instagram';
            default:
                return ucfirst($platform);
        }
    }
}
