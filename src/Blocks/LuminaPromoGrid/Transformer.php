<?php

namespace Lumina\ApiV2\Blocks\LuminaPromoGrid;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Button;
use Lumina\ApiV2\Helpers\Media;
use Lumina\ApiV2\Helpers\Product;

final class Transformer
{
    private const PROMOTIONS_LIMIT = 3;

    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        $promotions = AcfRepeater::parseFromBlockData(
            $data,
            'promotions',
            [
                'product',
                'subtitle',
                'title',
                'image',
                'lumina_promo_grid_is_contact_form',
                'lumina_promo_grid_label_button',
                'lumina_promo_grid_button',
                'lumina_promo_grid_contact_form',
            ],
            static function (array $item): array {
                return [
                    'product' => Product::parse($item['product']) ?? null,

                    'subtitle' => $item['subtitle'] ?? '',

                    'title' => $item['title'] ?? '',

                    'image' => Media::image(
                        $item['image'] ?? null
                    ),

                    'cta' => Button::parse(
                        $item['lumina_promo_grid_button'] ?? null
                    ),
                ];
            }
        );

        return BlockResponse::make(
            'promo_grid',
            [
                'promotions' => array_slice(
                    $promotions,
                    0,
                    self::PROMOTIONS_LIMIT
                ),
            ]
        );
    }
}
