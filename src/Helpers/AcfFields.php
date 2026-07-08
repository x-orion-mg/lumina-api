<?php

namespace Lumina\ApiV2\Helpers;

/**
 * Normalise récursivement les champs ACF pour l’API (images, HTML, repeaters).
 */
class AcfFields
{
    /**
     * @param mixed $fields
     * @return array<string, mixed>
     */
    public static function normalize($fields): array
    {
        if (!is_array($fields)) {
            return [];
        }

        $out = [];

        foreach ($fields as $key => $value) {
            if (!is_string($key) || $key === '' || $key[0] === '_') {
                continue;
            }

            $out[$key] = self::normalizeValue($value);
        }

        return $out;
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    private static function normalizeValue($value)
    {
        if (is_array($value)) {
            if (self::isImageShape($value)) {
                return Media::image($value);
            }

            if (self::isList($value)) {
                $list = [];

                foreach ($value as $item) {
                    $list[] = self::normalizeValue($item);
                }

                return $list;
            }

            return self::normalize($value);
        }

        if (is_numeric($value) && function_exists('wp_attachment_is_image') && wp_attachment_is_image((int) $value)) {
            return Media::image((int) $value);
        }

        if (is_string($value) && self::looksLikeHtml($value)) {
            return Wysiwyg::parse($value);
        }

        return $value;
    }

    /**
     * @param array<mixed> $value
     */
    private static function isImageShape(array $value): bool
    {
        return isset($value['url']) && (isset($value['ID']) || isset($value['id']) || isset($value['width']));
    }

    /**
     * @param array<mixed> $array
     */
    private static function isList(array $array): bool
    {
        if ($array === []) {
            return true;
        }

        return array_keys($array) === range(0, count($array) - 1);
    }

    private static function looksLikeHtml(string $value): bool
    {
        return strpos($value, '<') !== false && strpos($value, '>') !== false;
    }
}
