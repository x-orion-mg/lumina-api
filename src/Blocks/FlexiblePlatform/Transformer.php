<?php

namespace Lumina\ApiV2\Blocks\FlexiblePlatform;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Icon;

class Transformer
{
    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);
        // The block's name is "be-agile" but we want to return "flexible_platform" as the type in the API response
        return BlockResponse::make('be-agile', [

            'badge' => $data['badge'] ?? '',

            'title' => $data['title'] ?? '',

            'description' => $data['description'] ?? '',

            'cards' => AcfRepeater::parseFromBlockData(
                $data,
                'cards',
                ['icon_lumina', 'title', 'description'],
                static function (array $row): array {
                    return [
                        'icon' => Icon::parse($row['icon_lumina'] ?? null),
                        'title' => $row['title'] ?? '',
                        'description' => $row['description'] ?? '',
                    ];
                }
            ),

            'slider_hint' => $data['slider_hint'] ?? '',

        ]);
    }
}