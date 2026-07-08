<?php

namespace Lumina\ApiV2\Blocks\ComplianceTargets;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Icon;

class Transformer
{
    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);
        // The block's name is "be-confident" but we want to return "compliance_targets" as the type in the API response
        return BlockResponse::make('be-confident', [

            'badge' => $data['badge'] ?? '',

            'title' => $data['title'] ?? '',

            'description' => $data['description'] ?? '',

            'cards' => AcfRepeater::parseFromBlockData(
                $data,
                'cards',
                ['icon_lumina', 'title', 'description','link'],
                static function (array $row): array {
                    return [
                        'icon' => Icon::parse($row['icon_lumina'] ?? null),
                        'title' => $row['title'] ?? '',
                        'description' => $row['description'] ?? '',
                        'link' => $row['link'] ?? '',
                    ];
                }
            ),

        ]);
    }
}