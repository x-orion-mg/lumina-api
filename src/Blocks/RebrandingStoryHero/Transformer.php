<?php

namespace Lumina\ApiV2\Blocks\RebrandingStoryHero;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Cta;
use Lumina\ApiV2\Helpers\Icon;

class Transformer
{
    private const PRIMARY_PREFIX = 'primary_';
    private const SECONDARY_PREFIX = 'secondary_';

    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        return BlockResponse::make('rebranding_story_hero', [
            'badge'       => $data['badge'] ?? '',
            'title'       => $data['title'] ?? '',
            'description' => $data['description'] ?? '',

            'primary_button' => Cta::parse($data, [
                'mode_field'  => self::PRIMARY_PREFIX . 'is_contact_form',
                'label_field' => self::PRIMARY_PREFIX . 'label_button',
                'link_field'  => self::PRIMARY_PREFIX . 'button',
                'form_field'  => self::PRIMARY_PREFIX . 'contact_form',
            ]),

            'secondary_button' => Cta::parse($data, [
                'mode_field'  => self::SECONDARY_PREFIX . 'is_contact_form',
                'label_field' => self::SECONDARY_PREFIX . 'label_button',
                'link_field'  => self::SECONDARY_PREFIX . 'button',
                'form_field'  => self::SECONDARY_PREFIX . 'contact_form',
            ]),

            'features' => AcfRepeater::parseFromBlockData(
                $data,
                'features',
                ['icon_lumina', 'label'],
                static function (array $row): array {
                    return [
                        'icon'  => Icon::parse($row['icon_lumina'] ?? null),
                        'label' => $row['label'] ?? '',
                    ];
                }
            ),

            'visual_card' => [
                'description_card' => $data['description_card'] ?? '',
                'new_name' => $data['new_name'] ?? '',
                'label'    => $data['card_label'] ?? '',
            ],

            'stats' => AcfRepeater::parseFromBlockData(
                $data,
                'stats',
                ['label', 'value'],
                static function (array $row): array {
                    return [
                        'label' => $row['label'] ?? '',
                        'value' => $row['value'] ?? '',
                    ];
                }
            ),
        ]);
    }
}