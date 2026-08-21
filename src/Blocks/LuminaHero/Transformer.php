<?php

namespace Lumina\ApiV2\Blocks\LuminaHero;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Button;
use Lumina\ApiV2\Helpers\Media;

final class Transformer
{
    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        $heroSlider = AcfRepeater::parseFromBlockData(
            $data,
            'hero_slider',
            ['eyebrow','title','description','price','image','lumina_hero_slide_button'],
            static fn(array $item): array => [
                'eyebrow' => $item['eyebrow'] ?? '',
                'title' => $item['title'] ?? '',
                'description' => $item['description'] ?? '',
                'price' => $item['price'] ?? '',
                'image' => Media::image($item['image'] ?? null),
                'button' => Button::parse($item['lumina_hero_slide_button'] ?? null),
            ]
        );

        $cards = AcfRepeater::parseFromBlockData(
            $data,
            'cards',
            ['eyebrow','title','description','price','image','lumina_hero_card_button'],
            static fn(array $item): array => [
                'eyebrow' => $item['eyebrow'] ?? '',
                'title' => $item['title'] ?? '',
                'description' => $item['description'] ?? '',
                'price' => $item['price'] ?? '',
                'image' => Media::image($item['image'] ?? null),
                'button' => Button::parse($item['lumina_hero_card_button'] ?? null),
            ]
        );

        return BlockResponse::make('lumina_hero', [
            'hero_slider' => $heroSlider,
            'cards' => $cards,
        ]);
    }

}