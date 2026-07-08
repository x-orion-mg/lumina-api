<?php

namespace Lumina\ApiV2\Blocks\CtaSolutions;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Cta;

class Transformer
{
    private const PREFIX = 'cta_solutions_';

    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        return BlockResponse::make('cta_solutions', [
            'title'       => $data['title'] ?? '',
            'description' => $data['description'] ?? '',

            'button' => Cta::parse($data, [
                'mode_field'  => self::PREFIX . 'is_contact_form',
                'label_field' => self::PREFIX . 'label_button',
                'link_field'  => self::PREFIX . 'button',
                'form_field'  => self::PREFIX . 'contact_form',
            ]),
        ]);
    }
}