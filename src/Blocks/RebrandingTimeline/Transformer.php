<?php

namespace Lumina\ApiV2\Blocks\RebrandingTimeline;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Cta;
use Lumina\ApiV2\Helpers\Icon;

class Transformer
{
    private const BUTTON_PREFIX = 'timeline_';

    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        return BlockResponse::make('rebranding_timeline', [
            'badge' => $data['badge'] ?? '',
            'title' => $data['title'] ?? '',
            'description' => $data['description'] ?? '',

            'button' => Cta::parse($data, [
                'mode_field'  => self::BUTTON_PREFIX . 'is_contact_form',
                'label_field' => self::BUTTON_PREFIX . 'label_button',
                'link_field'  => self::BUTTON_PREFIX . 'button',
                'form_field'  => self::BUTTON_PREFIX . 'contact_form',
            ]),

            'items' => AcfRepeater::parseFromBlockData(
                $data,
                'items',
                [
                    'year',
                    'icon_lumina',
                    'title',
                    'description',
                ],
                static function (array $row): array {
                    return [
                        'year'        => $row['year'] ?? '',
                        'icon'        => Icon::parse($row['icon_lumina'] ?? null),
                        'title'       => $row['title'] ?? '',
                        'description' => $row['description'] ?? '',
                    ];
                }
            ),
        ]);
    }
}