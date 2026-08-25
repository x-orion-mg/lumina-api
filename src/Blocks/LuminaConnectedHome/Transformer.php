<?php

namespace Lumina\ApiV2\Blocks\LuminaConnectedHome;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Button;
use Lumina\ApiV2\Helpers\Media;

final class Transformer
{
    private const CARDS_LIMIT = 3;

    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        $cards = AcfRepeater::parseFromBlockData(
            $data,
            'cards',
            [
                'image',
                'title',
                'description',
            ],
            static function (array $item): array {
                return [
                    'image' => Media::image(
                        $item['image'] ?? null
                    ),

                    'title' => $item['title'] ?? '',

                    'description' => $item['description'] ?? '',
                ];
            }
        );

        return BlockResponse::make(
            'connected_home',
            [
                'subtitle' => $data['subtitle'] ?? '',

                'title' => $data['title'] ?? '',

                'cta' => Button::parse(
                    $data['lumina_connected_home_button'] ?? null
                ),

                'cards' => array_slice(
                    $cards,
                    0,
                    self::CARDS_LIMIT
                ),
            ]
        );
    }
}