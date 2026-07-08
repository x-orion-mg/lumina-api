<?php

namespace Lumina\ApiV2\Blocks\WhyChoose;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Icon;

class Transformer
{
    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);
        // The block's name is "be-different" but we want to return "why_choose" as the type in the API response
        return BlockResponse::make('be-different', [

            'badge' => $data['badge'] ?? '',

            'title' => $data['title'] ?? '',

            'description' => $data['description'] ?? '',

            'cards' => AcfRepeater::parseFromBlockData(
                $data,
                'cards',
                ['icon_lumina','title', 'card_description'],
                static function (array $item): array {

                    return [

                        'icon' => Icon::parse($item['icon_lumina'] ?? null),

                        'title' => $item['title'] ?? '',

                        'description' => $item['card_description'] ?? '',

                    ];
                }
            ),

        ]);
    }
}