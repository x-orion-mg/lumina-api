<?php

namespace Lumina\ApiV2\Blocks\HumanFirst;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Icon;

class Transformer
{
    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);
        // The block's name is "#Be HumanFirst" but we want to return "human_first" as the type in the API response
        return BlockResponse::make('be-HumanFirst', [

            'badge' => $data['badge'] ?? '',

            'title' => $data['title'] ?? '',

            'description' => $data['description'] ?? '',

            'features' => AcfRepeater::parseFromBlockData(
                $data,
                'features',
                [
                    'icon_lumina',
                    'title',
                    'description',
                    'gradient_color',
                ],
                static function (array $row): array {
                    return [
                        'icon' => Icon::parse($row['icon_lumina'] ?? null),
                        'title' => $row['title'] ?? '',
                        'description' => $row['description'] ?? '',
                        'gradient_color' => $row['gradient_color'] ?? '',
                    ];
                }
            ),

            'bottom_items' => AcfRepeater::parseFromBlockData(
                $data,
                'bottom_items',
                [
                    'icon_lumina',
                    'title',
                ],
                static function (array $row): array {
                    return [
                        'icon' => Icon::parse($row['icon_lumina'] ?? null),
                        'title' => $row['title'] ?? '',
                    ];
                }
            ),

        ]);
    }
}