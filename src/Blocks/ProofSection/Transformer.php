<?php

namespace Lumina\ApiV2\Blocks\ProofSection;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Icon;
use Lumina\ApiV2\Helpers\Media;

class Transformer
{
    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        return BlockResponse::make('proof_section', [

            'badge' => $data['badge'] ?? '',

            'title' => $data['title'] ?? '',

            'description' => $data['description'] ?? '',

            'button' => $data['button'] ?? '',

            'stats' => AcfRepeater::parseFromBlockData(
                $data,
                'stats',
                ['value', 'suffix', 'description', 'icon_lumina'],
                static function (array $row): array {
                return [
                    'icon' => Icon::parse($row['icon_lumina'] ?? null),
                    'value' => $row['value'] ?? '',
                    'suffix' => $row['suffix'] ?? '',
                    'description' => $row['description'] ?? '',
                ];
            }
            ),

        ]);
    }
}