<?php

namespace Lumina\ApiV2\Blocks\Hero;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Media;

class Transformer
{
    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        return BlockResponse::make('hero', [
            'title' => $data['title'] ?? '',
            'image' => Media::image($data['image'] ?? null),
        ]);
    }
}
