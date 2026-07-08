<?php

namespace Lumina\ApiV2\Blocks\BeInspired;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Button;
use Lumina\ApiV2\Helpers\Icon;

class Transformer
{
    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        return BlockResponse::make('be-inspired', [

            'tag' => $data['tag'] ?? '',

            'title' => $data['title'] ?? '',

            'description' => $data['description'] ?? '',

            'button' => Button::parse($data['button'] ?? null),

            'items' => AcfRepeater::parseFromBlockData(
                $data,
                'items',
                ['icon_lumina', 'title', 'color'],
                static function (array $item): array {
                    return [

                        'icon' => Icon::parse($item['icon_lumina'] ?? null),

                        'title' => $item['title'] ?? '',

                        'color' => $item['color'] ?? '',

                    ];
                }
            ),

        ]);
    }
}