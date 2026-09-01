<?php

namespace Lumina\ApiV2\Blocks\LuminaPromoBanner;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Button;
use Lumina\ApiV2\Helpers\Media;

final class Transformer
{
    private const CARDS_LIMIT = 2;

    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        $cards = AcfRepeater::parseFromBlockData(
            $data,
            'cards',
            [
                'subtitle',
                'title',
                'description',
                'images',
                'lumina_promo_banner_button',
            ],
            static function (array $item): array {
                return [
                    'subtitle' => $item['subtitle'] ?? '',

                    'title' => $item['title'] ?? '',

                    'description' => $item['description'] ?? '',

                    'images' => Media::images(
                        $item['images'] ?? null
                    ),

                    'cta' => Button::parse(
                        $item['lumina_promo_banner_button'] ?? null
                    ),
                ];
            }
        );

        return BlockResponse::make(
            'promo_banner',
            [
                'cards' => array_slice(
                    $cards,
                    0,
                    self::CARDS_LIMIT
                ),
            ]
        );
    }
}