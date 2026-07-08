<?php

namespace Lumina\ApiV2\Services;

use Lumina\ApiV2\Transformers\FooterTransformer;

class FooterService
{
    public static function get(string $lang): array
    {
        $lang = LanguageService::normalizeFromRequest($lang);

        return LanguageService::runWithLanguage($lang, function () use ($lang) {
            $data = function_exists('get_fields') ? (get_fields('option') ?: []) : [];

            return FooterTransformer::transform($data, $lang);
        });
    }
}
