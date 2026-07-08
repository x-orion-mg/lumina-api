<?php

namespace Lumina\ApiV2\Blocks\WhyChooseSolutions;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\BlockResponse;

class Transformer
{
    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        return BlockResponse::make('why_choose_solutions', [
            'title' => $data['title'] ?? '',

            'items' => AcfRepeater::parseFromBlockData(
                $data,
                'items',
                [
                    'title',
                    'description',
                ],
                static function (array $row): array {
                    return [
                        'title'       => $row['title'] ?? '',
                        'description' => $row['description'] ?? '',
                    ];
                }
            ),
        ]);
    }
}