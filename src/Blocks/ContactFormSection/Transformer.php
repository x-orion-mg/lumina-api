<?php

namespace Lumina\ApiV2\Blocks\ContactFormSection;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Wysiwyg;
use Lumina\ApiV2\Services\HubSpotFormService;

class Transformer
{
    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        return BlockResponse::make('contact_form_section', [
            'tag'         => $data['tag'] ?? '',
            'title'       => $data['title'] ?? '',
            'description' => $data['description'] ?? '',

            'form' => HubSpotFormService::resolveEmbedded(
                $data['form'] ?? null,
                [
                    'title'       => $data['form_title'] ?? '',
                    'description' => $data['form_description'] ?? '',
                    'conditions'  => Wysiwyg::parse(
                        $data['description_conditions'] ?? ''
                    ),
                ]
            ),
        ]);
    }
}