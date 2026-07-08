<?php

namespace Lumina\ApiV2\Blocks\LegalMentions;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Wysiwyg;

class Transformer
{
    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        return BlockResponse::make('legal_mentions', [
            'title'       => $data['title'] ?? '',
            'description' => $data['description'] ?? '',
            'sections'    => AcfRepeater::parseFromBlockData(
                $data,
                'sections',
                ['title', 'content'],
                static function (array $row): array {
                    return [
                        'title'   => $row['title'] ?? '',
                        'content' => Wysiwyg::parse($row['content'] ?? ''),
                    ];
                }
            ),
        ]);
    }
}