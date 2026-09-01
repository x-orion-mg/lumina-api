<?php

namespace Lumina\ApiV2\Helpers;

class Media
{
    /**
     * Normalise un champ image ACF (ID, tableau ou URL) pour l'API.
     */
    public static function image($value): ?array
    {
        if (empty($value)) {
            return null;
        }

        if (is_string($value) && filter_var($value, FILTER_VALIDATE_URL)) {
            return [
                'url' => $value,
                'alt' => '',
            ];
        }

        if (is_array($value)) {
            $id = $value['ID'] ?? $value['id'] ?? null;

            if (!empty($value['url'])) {
                return [
                    'id'    => $id ? (int) $id : null,
                    'url'   => $value['url'],
                    'alt'   => (string) ($value['alt'] ?? ''),
                    'width' => isset($value['width']) ? (int) $value['width'] : null,
                    'height' => isset($value['height']) ? (int) $value['height'] : null,
                ];
            }

            if ($id) {
                return self::fromAttachmentId((int) $id);
            }

            return null;
        }

        if (is_numeric($value)) {
            return self::fromAttachmentId((int) $value);
        }

        return null;
    }

    private static function fromAttachmentId(int $id): ?array
    {
        $url = wp_get_attachment_image_url($id, 'full');

        if (!$url) {
            return null;
        }

        $meta = wp_get_attachment_metadata($id);

        return [
            'id'     => $id,
            'url'    => $url,
            'alt'    => (string) get_post_meta($id, '_wp_attachment_image_alt', true),
            'width'  => isset($meta['width']) ? (int) $meta['width'] : null,
            'height' => isset($meta['height']) ? (int) $meta['height'] : null,
        ];
    }

    public static function images(mixed $images): array
    {
        if (empty($images) || !is_array($images)) {
            return [];
        }

        return array_values(
            array_filter(
                array_map(
                    fn ($image) => self::image($image),
                    $images
                )
            )
        );
    }

}
