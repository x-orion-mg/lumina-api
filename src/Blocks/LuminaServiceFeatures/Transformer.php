<?php

namespace Lumina\ApiV2\Blocks\LuminaServiceFeatures;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Icon;

final class Transformer
{
    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        $features = AcfRepeater::parseFromBlockData(
            $data,
            'features',
            [
                'icon_lumina',
                'title',
                'description',
            ],
            static function (array $item): array {
                return [
                    'icon' => Icon::parse(
                        $item['icon_lumina'] ?? null
                    ),

                    'title' => $item['title'] ?? '',

                    'description' => $item['description'] ?? '',
                ];
            }
        );

        return BlockResponse::make(
            'lumina_service_features',
            [
                'features' => $features,
            ]
        );
    }
}