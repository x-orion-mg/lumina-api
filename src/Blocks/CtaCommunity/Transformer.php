<?php

namespace Lumina\ApiV2\Blocks\CtaCommunity;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Cta;

class Transformer
{
    private const PRIMARY_PREFIX = 'primary_cta_';
    private const SECONDARY_PREFIX = 'secondary_cta_';

    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        return BlockResponse::make('cta_community', [
            'eyebrow' => $data['eyebrow'] ?? '',
            'title' => $data['title'] ?? '',
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
        ]);
    }
}