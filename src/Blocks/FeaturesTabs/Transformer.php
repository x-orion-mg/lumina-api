<?php

namespace Lumina\ApiV2\Blocks\FeaturesTabs;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Button;
use Lumina\ApiV2\Helpers\Icon;
use Lumina\ApiV2\Helpers\Media;

class Transformer
{
    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);
        // The block's name is "be-smart" but we want to return "features_tabs" as the type in the API response
        return BlockResponse::make('be-smart', [

            'badge' => $data['badge'] ?? '',

            'title' => $data['title'] ?? '',

            'description' => $data['description'] ?? '',

            'tabs' => AcfRepeater::parseFromBlockData(
                $data,
                'tabs',
                ['icon_lumina', 'label', 'title', 'content_description', 'button', 'visual'],
                static function (array $item, int $index, array $sourceData): array {
                    return [
                        'icon' => Icon::parse($item['icon_lumina'] ?? null),

                        'label' => $item['label'] ?? '',

                        'title' => $item['title'] ?? '',

                        'description' => $item['content_description'] ?? '',

                        'features' => self::parseFeatures($item, $index, $sourceData),

                        'button' => Button::parse($item['button'] ?? null),

                        'visual' => Media::image($item['visual'] ?? null),
                    ];
                }
            ),

        ]);
    }

    /**
     * @param array<string, mixed> $item
     * @param array<string, mixed> $sourceData
     */
    private static function parseFeatures(array $item, int $tabIndex, array $sourceData): array
    {
        $features = $item['features'] ?? null;

        if (is_array($features)) {
            return AcfRepeater::parse(
                $features,
                static fn(array $feature): array => [
                    'text' => $feature['text'] ?? '',
                ]
            );
        }

        return AcfRepeater::parseFromBlockDataPrefixed(
            $sourceData,
            "tabs_{$tabIndex}_",
            'features',
            ['text'],
            static fn(array $feature): array => [
                'text' => $feature['text'] ?? '',
            ]
        );
    }
}
