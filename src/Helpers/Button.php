<?php

namespace Lumina\ApiV2\Helpers;

class Button
{
    private const HUBSPOT_HOST_FRAGMENTS = [
        'hubspot.com',
        'hsforms.com',
        'meetings.hubspot.com',
        'hubspot.net',
        'hs-sites.com',
    ];

    /**
     * Normalise un bouton / lien ACF (champ link, groupe custom, URL seule) pour l'API.
     *
     * Formats acceptés :
     * - Champ ACF Link : [ 'url' => '', 'title' => '', 'target' => '' ]
     * - Groupe type bouton : label + url (+ target, variant, hubspot_*)
     * - Chaîne : URL brute
     *
     * @param mixed $value
     */
    public static function parse($value): ?array
    {
        if ($value === null || $value === '' || $value === []) {
            return null;
        }

        if (is_string($value)) {
            $url = trim($value);

            if ($url === '') {
                return null;
            }

            return self::build('', $url, '');
        }

        if (!is_array($value)) {
            return null;
        }

        $value = AcfRepeater::stripInternalKeys($value);

        // Champ ACF "Link" ou groupe avec clés url / title / target
        if (isset($value['url']) || isset($value['link'])) {
            $link = $value['link'] ?? $value;

            if (is_array($link)) {
                $link = AcfRepeater::stripInternalKeys($link);
            }

            $url = '';

            if (is_array($link)) {
                $url = (string) ($link['url'] ?? '');
            }

            $linkTitle = is_array($link) ? (string) ($link['title'] ?? '') : '';
            $label = (string) ($value['label'] ?? $value['title'] ?? $linkTitle);
            $target = (string) ($value['target'] ?? (is_array($link) ? ($link['target'] ?? '') : ''));

            if ($url === '' && is_array($link)) {
                $url = (string) ($link['url'] ?? '');
            }

            if ($url === '') {
                return null;
            }

            return self::build($label, $url, $target, $value);
        }

        // Groupe sans clé "url" explicite : première URL trouvée
        foreach (['button_url', 'href', 'hubspot_url', 'meeting_url'] as $key) {
            if (!empty($value[$key]) && is_string($value[$key])) {
                $label = (string) ($value['label'] ?? $value['title'] ?? $value['text'] ?? '');
                $target = (string) ($value['target'] ?? '');

                return self::build($label, trim($value[$key]), $target, $value);
            }
        }

        return null;
    }

    /**
     * @param array<string, mixed> $raw Champs additionnels du groupe ACF (variant, classes, etc.).
     */
    private static function build(string $label, string $url, string $target, array $raw = []): array
    {
        $target = self::normalizeTarget($target);
        $type = self::detectType($url);
        $hubspot = self::isHubSpotUrl($url) || !empty($raw['hubspot_form_id']) || !empty($raw['hubspot_portal_id']);

        $out = [
            'label'   => $label !== '' ? $label : self::defaultLabelFromUrl($url),
            'url'     => $url,
            'target'  => $target,
            'type'    => $hubspot ? 'hubspot' : $type,
            'hubspot' => $hubspot,
        ];

        foreach (['variant', 'style', 'class', 'classes', 'icon'] as $k) {
            if (array_key_exists($k, $raw) && $raw[$k] !== '' && $raw[$k] !== null) {
                $out[$k] = $raw[$k];
            }
        }

        foreach (['hubspot_form_id', 'hubspot_portal_id', 'hubspot_region'] as $k) {
            if (!empty($raw[$k])) {
                $out[$k] = $raw[$k];
            }
        }

        $slug = self::resolvePageSlug($url, $hubspot ? 'hubspot' : $type, $raw);

        if ($slug !== null && $slug !== '') {
            $out['slug'] = $slug;
        }

        return $out;
    }

    /**
     * Slug WordPress d’une page / article pour les liens internes (headless routing).
     *
     * @param array<string, mixed> $raw
     */
    private static function resolvePageSlug(string $url, string $type, array $raw = []): ?string
    {
        if (!in_array($type, ['internal', 'relative'], true)) {
            return null;
        }

        $postId = self::postIdFromRaw($raw);

        if ($postId === null) {
            $postId = self::postIdFromUrl($url);
        }

        if ($postId !== null && $postId > 0) {
            $slug = get_post_field('post_name', $postId);

            if (is_string($slug) && $slug !== '') {
                return $slug;
            }
        }

        return self::slugFromUrlPath($url);
    }

    /**
     * @param array<string, mixed> $raw
     */
    private static function postIdFromRaw(array $raw): ?int
    {
        foreach (['post', 'page', 'post_id', 'ID', 'id'] as $key) {
            if (empty($raw[$key])) {
                continue;
            }

            $value = $raw[$key];

            if (is_numeric($value)) {
                return (int) $value;
            }

            if (is_object($value) && isset($value->ID)) {
                return (int) $value->ID;
            }

            if (is_array($value) && !empty($value['ID'])) {
                return (int) $value['ID'];
            }
        }

        return null;
    }

    private static function postIdFromUrl(string $url): ?int
    {
        if (!function_exists('url_to_postid')) {
            return null;
        }

        $postId = (int) url_to_postid($url);

        if ($postId > 0) {
            return $postId;
        }

        $path = parse_url($url, PHP_URL_PATH);

        if (is_string($path) && $path !== '' && Str::startsWith($path, '/')) {
            $postId = (int) url_to_postid(home_url($path));
        }

        return $postId > 0 ? $postId : null;
    }

    /**
     * Dernier segment du chemin (ex. /en/service/ → service) si url_to_postid échoue.
     */
    private static function slugFromUrlPath(string $url): ?string
    {
        $path = parse_url($url, PHP_URL_PATH);

        if (!is_string($path) || $path === '' || $path === '/') {
            if (Str::startsWith($url, '/')) {
                $path = $url;
            } else {
                return null;
            }
        }

        $segments = array_values(array_filter(explode('/', trim($path, '/'))));

        if ($segments === []) {
            return null;
        }

        $slug = (string) end($segments);

        return $slug !== '' ? $slug : null;
    }

    private static function normalizeTarget(string $target): string
    {
        $target = trim($target);

        if ($target === '_blank' || $target === '_self') {
            return $target;
        }

        return '_self';
    }

    private static function detectType(string $url): string
    {
        if ($url === '') {
            return 'unknown';
        }

        if (Str::startsWith($url, 'mailto:')) {
            return 'mailto';
        }

        if (Str::startsWith($url, 'tel:')) {
            return 'tel';
        }

        if (Str::startsWith($url, '#')) {
            return 'hash';
        }

        $host = parse_url($url, PHP_URL_HOST);

        if ($host && self::isHubSpotUrl($url)) {
            return 'hubspot';
        }

        if ($host) {
            $site = wp_parse_url(home_url(), PHP_URL_HOST);

            if ($site && strcasecmp((string) $host, (string) $site) === 0) {
                return 'internal';
            }

            return 'external';
        }

        return 'relative';
    }

    private static function isHubSpotUrl(string $url): bool
    {
        $host = parse_url($url, PHP_URL_HOST);

        if (!$host) {
            return false;
        }

        $host = strtolower((string) $host);

        foreach (self::HUBSPOT_HOST_FRAGMENTS as $fragment) {
            if (Str::contains($host, $fragment)) {
                return true;
            }
        }

        return false;
    }

    private static function defaultLabelFromUrl(string $url): string
    {
        if (Str::startsWith($url, 'mailto:')) {
            return substr($url, 7);
        }

        if (Str::startsWith($url, 'tel:')) {
            return substr($url, 4);
        }

        return '';
    }
}
