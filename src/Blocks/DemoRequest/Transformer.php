<?php

namespace Lumina\ApiV2\Blocks\DemoRequest;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Icon;
use Lumina\ApiV2\Helpers\Wysiwyg;
use Lumina\ApiV2\Services\HubSpotFormService;

class Transformer
{
    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        $benefits = AcfRepeater::parseFromBlockData(
            $data,
            'benefits',
            ['icon_lumina', 'text'],
            static fn(array $item): array => [
                'icon' => Icon::parse($item['icon_lumina'] ?? null),
                'text' => $item['text'] ?? '',
            ]
        );

        $formId = $data['form'] ?? null;

        if (is_numeric($formId)) {
            $formId = [(int) $formId];
        }

        return BlockResponse::make('demo_request', [

            'tag' => $data['tag'] ?? '',

            'title' => $data['title'] ?? '',

            'description' => $data['description'] ?? '',

            'benefits' => $benefits,

            'form' => HubSpotFormService::resolveEmbedded($formId, [
                'title'       => $data['form_title'] ?? '',
                'description' => $data['form_description'] ?? '',
                'conditions'  => Wysiwyg::parse($data['description_conditions'] ?? ''),
            ]),

        ]);
    }
}
