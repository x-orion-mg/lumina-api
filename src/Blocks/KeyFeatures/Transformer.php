<?php

namespace Lumina\ApiV2\Blocks\KeyFeatures;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Icon;

class Transformer
{
    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        return BlockResponse::make('key_features', [
            'title' => $data['title'] ?? '',
            'description' => $data['description'] ?? '',

            'items' => AcfRepeater::parseFromBlockData(
                $data,
                'items',
                [
                    'text',
                ],
                static function (array $row): array {
                    return [
                        'text' => $row['text'] ?? '',
                    ];
                }
            ),
        ]);
    }
}