<?php

namespace Lumina\ApiV2\Blocks\HeroMain;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Media;

class Transformer
{
    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        return BlockResponse::make('hero_main', [

            'badge_text' => $data['badge_text'] ?? '',

            'title' => $data['title'] ?? '',

            'description' => $data['description'] ?? '',

            'primary_button' => [
                'title' => $data['primary_button']['title'] ?? '',
                'url' => $data['primary_button']['url'] ?? '',
                'target' => $data['primary_button']['target'] ?? '_self',
            ],

            'secondary_button' => [
                'title' => $data['secondary_button']['title'] ?? '',
                'url' => $data['secondary_button']['url'] ?? '',
                'target' => $data['secondary_button']['target'] ?? '_self',
            ],

            'stats' => AcfRepeater::parseFromBlockData($data, 'stats', ['value', 'label']),

            'hero_mockup' => Media::image(
                $data['hero_mockup'] ?? null
            ),

            'notification' => [
                'title' => $data['notification_text'] ?? '',
                'subtitle' => $data['notification_subtitle'] ?? '',
            ],

            'resolution_rate' => $data['resolution_rate'] ?? '',

        ]);
    }
}