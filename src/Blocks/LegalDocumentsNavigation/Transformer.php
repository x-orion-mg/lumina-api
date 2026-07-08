<?php

namespace Lumina\ApiV2\Blocks\LegalDocumentsNavigation;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Button;
use Lumina\ApiV2\Helpers\Cta;
use Lumina\ApiV2\Helpers\Icon;

class Transformer
{
    private const HELP_PREFIX = 'help_';

    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        return BlockResponse::make('legal_documents_navigation', [
            'search_placeholder' => $data['search_placeholder'] ?? '',

            'icon' => Icon::parse($data['icon_lumina'] ?? null),

            'label' => $data['label'] ?? '',
            'title' => $data['title'] ?? '',
            'title_section' => $data['title_section'] ?? '',
            'last_update' => $data['last_update'] ?? '',

            'help' => [
                'title'       => $data['help_title'] ?? '',
                'description' => $data['help_description'] ?? '',
                'button'      => Cta::parse($data, [
                    'mode_field'  => self::HELP_PREFIX . 'is_contact_form',
                    'label_field' => self::HELP_PREFIX . 'label_button',
                    'link_field'  => self::HELP_PREFIX . 'button',
                    'form_field'  => self::HELP_PREFIX . 'contact_form',
                ]),
            ],

            'documents' => AcfRepeater::parseFromBlockData(
                $data,
                'documents',
                ['link'],
                static function (array $row): array {
                    return [
                        'link'  => Button::parse($row['link'] ?? null),
                    ];
                }
            ),
        ]);
    }
}