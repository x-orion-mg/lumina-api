<?php

namespace Lumina\ApiV2\Services;

use Lumina\ApiV2\Transformers\OthersTransformer;

class OthersService
{
    public static function get(string $lang, ?string $type = null): array
    {
        $lang = LanguageService::normalizeFromRequest($lang);

        return LanguageService::runWithLanguage($lang, function () use ($lang, $type) {
            $data = function_exists('get_fields') ? (get_fields('option') ?: []) : [];

            return OthersTransformer::transform($data, $lang, $type);
        });
    }
}
