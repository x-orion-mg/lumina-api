<?php

namespace Lumina\ApiV2\Blocks\FaqSection;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Wysiwyg;

class Transformer
{
    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        return BlockResponse::make('faq_section', [
            'badge' => $data['badge'] ?? '',
            'title' => $data['title'] ?? '',
            'items' => AcfRepeater::parseFromBlockData(
                $data,
                'items',
                ['question', 'answer'],
                static function (array $row): array {
                    return [
                        'question' => $row['question'] ?? '',
                        'answer'   => Wysiwyg::parse($row['answer'] ?? ''),
                    ];
                }
            ),
        ]);
    }
}