<?php

namespace Lumina\ApiV2\Blocks\GetStarted;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Button;

class Transformer
{
    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        return BlockResponse::make('cta_banner', [

            'tag' => $data['tag'] ?? '',

            'title' => $data['title'] ?? '',

            'description' => $data['description'] ?? '',

            'primary_button' =>  Button::parse($data['primary_button'] ?? null),

            'secondary_button' => Button::parse($data['secondary_button'] ?? null),

        ]);
    }
}