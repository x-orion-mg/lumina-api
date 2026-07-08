<?php

namespace Lumina\ApiV2\Services;

use Lumina\ApiV2\Transformers\HeaderTransformer;

class HeaderService
{
    public static function get(string $lang): array
    {
        $lang = LanguageService::normalizeFromRequest($lang);

        return LanguageService::runWithLanguage($lang, function () use ($lang) {
            $data = function_exists('get_fields') ? (get_fields('option') ?: []) : [];

            return HeaderTransformer::transform($data, $lang);
        });
    }
}
