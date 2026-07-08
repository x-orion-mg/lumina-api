<?php

namespace Lumina\ApiV2\Blocks\AboutStats;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\BlockResponse;

class Transformer
{
    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        $cards = AcfRepeater::parseFromBlockData(
            $data,
            'cards',
            ['value','text'],
            static fn(array $item): array => [
                'value' => $item['value'] ?? '',
                'text' => $item['text'] ?? '',
            ]
        );

        return BlockResponse::make('about_stats', [

            'label' => $data['label'] ?? '',

            'title' => $data['title'] ?? '',

            'description' => $data['description'] ?? '',

            'cards' => $cards,

        ]);
    }
}