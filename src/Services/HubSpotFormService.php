<?php

namespace Lumina\ApiV2\Services;

class HubSpotFormService
{
    /**
     * Résout un formulaire contact (CPT contact-form) pour l’API headless.
     *
     * @param mixed $contactFormId ID, tableau d’IDs (relationship ACF), ou objet post.
     */
    public static function resolve($contactFormId, ?string $label = null): ?array
    {
        $id = self::normalizeId($contactFormId);

        if ($id === null) {
            return null;
        }

        $hubspot = self::hubspotParams($id);

        if ($hubspot === [] && $label === null) {
            return null;
        }

        $payload = [
            'id'      => $id,
            'title'   => get_the_title($id) ?: '',
            'slug'    => get_post_field('post_name', $id) ?: '',
            'hubspot' => $hubspot,
        ];

        if ($label !== null && $label !== '') {
            $payload['label'] = $label;
        }

        return apply_filters('lumina_api_v2_hubspot_form', $payload, $id);
    }

    /**
     * Bloc avec formulaire HubSpot intégré (relationship + métadonnées éditoriales).
     *
     * @param mixed $contactFormId
     * @param array<string, mixed> $meta title, description, conditions, etc.
     */
    public static function resolveEmbedded($contactFormId, array $meta = []): ?array
    {
        $form = self::resolve($contactFormId, null);

        if ($form === null) {
            return null;
        }

        $out = [
            'type'          => 'hubspot_form',
            'contact_form'  => $form,
        ];

        foreach (['title', 'description', 'conditions'] as $key) {
            if (isset($meta[$key]) && $meta[$key] !== '' && $meta[$key] !== []) {
                $out[$key] = $meta[$key];
            }
        }

        return $out;
    }

    /**
     * @param mixed $value
     */
    public static function normalizeId($value): ?int
    {
        if ($value === null || $value === '' || $value === []) {
            return null;
        }

        if (is_numeric($value)) {
            $id = (int) $value;

            return $id > 0 ? $id : null;
        }

        if (is_object($value) && isset($value->ID)) {
            $id = (int) $value->ID;

            return $id > 0 ? $id : null;
        }

        if (!is_array($value)) {
            return null;
        }

        if (isset($value['ID'])) {
            $id = (int) $value['ID'];

            return $id > 0 ? $id : null;
        }

        if (isset($value['id'])) {
            $id = (int) $value['id'];

            return $id > 0 ? $id : null;
        }

        $first = reset($value);

        return self::normalizeId($first);
    }

    /**
     * @return array{type?: string, portalId?: string, formId?: string}
     */
    private static function hubspotParams(int $postId): array
    {
        if (class_exists('CContactForm', false)) {
            $contactForm = \CContactForm::getById($postId);

            if (
                is_object($contactForm)
                && !empty($contactForm->short_code_hubspot)
                && is_array($contactForm->short_code_hubspot)
            ) {
                return self::normalizeHubspotKeys($contactForm->short_code_hubspot);
            }
        }

        if (!function_exists('get_field')) {
            return [];
        }

        $shortcode = get_field('short_code_hubspot', $postId);

        if (!is_string($shortcode) || $shortcode === '') {
            return [];
        }

        return self::parseShortcode($shortcode);
    }

    /**
     * @param array<string, mixed> $params
     * @return array{type?: string, portalId?: string, formId?: string}
     */
    private static function normalizeHubspotKeys(array $params): array
    {
        return [
            'type'     => (string) ($params['type'] ?? ''),
            'portalId' => (string) ($params['portalId'] ?? $params['portal'] ?? ''),
            'formId'   => (string) ($params['formId'] ?? $params['id'] ?? ''),
        ];
    }

    /**
     * Parse [hubspot type="..." portal="..." id="..."].
     *
     * @return array{type?: string, portalId?: string, formId?: string}
     */
    public static function parseShortcode(string $shortcode): array
    {
        if (!preg_match('/\[hubspot(.*?)\]/', $shortcode, $matches)) {
            return [];
        }

        if (!function_exists('shortcode_parse_atts')) {
            return [];
        }

        $atts = shortcode_parse_atts($matches[1] ?? '');

        if (!is_array($atts)) {
            return [];
        }

        return self::normalizeHubspotKeys([
            'type'   => $atts['type'] ?? '',
            'portal' => $atts['portal'] ?? '',
            'id'     => $atts['id'] ?? '',
        ]);
    }
}
