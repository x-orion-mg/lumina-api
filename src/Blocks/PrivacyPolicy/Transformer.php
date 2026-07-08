<?php

namespace Lumina\ApiV2\Blocks\PrivacyPolicy;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Icon;
use Lumina\ApiV2\Helpers\Wysiwyg;

class Transformer
{
    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        return BlockResponse::make('privacy_policy', [
            'title'       => $data['title'] ?? '',
            'description' => $data['description'] ?? '',
            'tabs'        => AcfRepeater::parseFromBlockData(
                $data,
                'tabs',
                ['icon_lumina', 'title'],
                static function (array $tab, int $index, array $sourceData): array {
                    return [
                        'icon'    => Icon::parse($tab['icon_lumina'] ?? null),
                        'title'   => $tab['title'] ?? '',
                        'section' => AcfRepeater::parseFromBlockData(
                            $sourceData,
                            "tabs_{$index}_section",
                            ['title', 'content'],
                            static function (array $section): array {
                                return [
                                    'title'   => $section['title'] ?? '',
                                    'content' => Wysiwyg::parse($section['content'] ?? ''),
                                ];
                            }
                        ),
                    ];
                }
            ),
        ]);
    }
}