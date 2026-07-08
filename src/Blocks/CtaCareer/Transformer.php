<?php

namespace Lumina\ApiV2\Blocks\CtaCareer;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Cta;

class Transformer
{
    private const BUTTON_PREFIX = 'cta_career_';

    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        return BlockResponse::make('cta_career', [

            'title' => $data['title'] ?? '',

            'description' => $data['description'] ?? '',

            'button' => Cta::parse($data, [
                'mode_field'  => self::BUTTON_PREFIX . 'is_contact_form',
                'label_field' => self::BUTTON_PREFIX . 'label_button',
                'link_field'  => self::BUTTON_PREFIX . 'button',
                'form_field'  => self::BUTTON_PREFIX . 'contact_form',
            ]),

        ]);
    }
}
