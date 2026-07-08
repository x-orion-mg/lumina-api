<?php

namespace Lumina\ApiV2\Transformers;

use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\Button;
use Lumina\ApiV2\Helpers\Cta;
use Lumina\ApiV2\Helpers\Icon;

class OthersTransformer
{
    private const HELP_PREFIX = 'legal_help_';

    /**
     * @param array<string, mixed> $data Champs options (legal_*).
     */
    public static function transform(array $data, string $lang, ?string $type = null): array
    {
        $legalDocumentsNavigation = self::legalDocumentsNavigation($data);

        if ($type === 'legal_documents_navigation') {
            return [
                'lang' => $lang,
                'legal_documents_navigation' => $legalDocumentsNavigation,
            ];
        }

        return [
            'lang' => $lang,
            'legal_documents_navigation' => $legalDocumentsNavigation,
        ];
    }

    private static function legalDocumentsNavigation(array $data): array
    {
        return [
            'search_placeholder' => $data['legal_search_placeholder'] ?? '',
            'title_section' => $data['legal_title_section'] ?? '',
            'last_update' => $data['legal_last_update'] ?? '',
            'help' => [
                'title' => $data['legal_help_title'] ?? '',
                'description' => $data['legal_help_description'] ?? '',
                'button' => Cta::parse($data, [
                    'mode_field' => self::HELP_PREFIX . 'is_contact_form',
                    'label_field' => self::HELP_PREFIX . 'label_button',
                    'link_field' => self::HELP_PREFIX . 'button',
                    'form_field' => self::HELP_PREFIX . 'contact_form',
                ]),
            ],
            'documents' => [
                'title' => $data['legal_documents_title'] ?? '',
                'link_list' => AcfRepeater::parse(
                    $data['legal_documents'] ?? [],
                    static function (array $row): array {
                        return [
                            'link' => Button::parse($row['link'] ?? null),
                        ];
                    }
                ),
            ],
        ];
    }
}
