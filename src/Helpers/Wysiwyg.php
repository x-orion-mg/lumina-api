<?php

namespace Lumina\ApiV2\Helpers;

/**
 * Contenu ACF WYSIWYG : réécriture des liens internes vers le slug de page (routing headless).
 */
class Wysiwyg
{
    /**
     * Transforme le HTML : href internes → /{slug} (filtres WordPress applicables).
     */
    public static function parse(?string $html): string
    {
        if ($html === null || trim($html) === '') {
            return '';
        }

        $parsed = preg_replace_callback(
            '/<a\b([^>]*?)\s*href\s*=\s*(["\'])([^"\']*)\2([^>]*)>/iu',
            static function (array $matches): string {
                $before = $matches[1] ?? '';
                $quote = $matches[2];
                $href = $matches[3];
                $after = $matches[4] ?? '';

                $replacement = self::internalHref($href);

                if ($replacement === null) {
                    return $matches[0];
                }

                return '<a' . $before . ' href=' . $quote . esc_attr($replacement) . $quote . $after . '>';
            },
            $html
        );

        if (!is_string($parsed)) {
            $parsed = $html;
        }

        /**
         * Filtre global sur le HTML WYSIWYG déjà traité.
         *
         * @param string $parsed HTML transformé
         * @param string $html   HTML source
         */
        return (string) apply_filters('lumina_api_v2_wysiwyg', $parsed, $html);
    }

    /**
     * Résout une URL interne en chemin slug pour l’API (/slug ou /fr/slug selon filtres).
     */
    public static function internalHref(string $url): ?string
    {
        $url = html_entity_decode(trim($url), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        if ($url === '' || self::isSkippableScheme($url)) {
            return null;
        }

        if (!self::isInternalUrl($url)) {
            return null;
        }

        $original = $url;

        if (function_exists('apply_filters')) {
            $url = (string) apply_filters('lumina_api_link', $url);
        }

        $postId = self::postIdFromUrl($original);

        if ($postId === null && $url !== $original) {
            $postId = self::postIdFromUrl($url);
        }

        $slug = self::slugForPost($postId, $url);

        if ($slug === null) {
            return null;
        }

        $path = '/' . ltrim($slug, '/');

        /**
         * Filtre par lien interne détecté.
         *
         * @param string   $path     Chemin proposé (ex. /mentions-legales)
         * @param int|null $postId   ID WordPress si trouvé
         * @param string   $original URL d’origine dans le href
         */
        return (string) apply_filters('lumina_api_v2_wysiwyg_internal_url', $path, $postId, $original);
    }

    private static function isSkippableScheme(string $url): bool
    {
        return Str::startsWith($url, '#')
            || Str::startsWith($url, 'mailto:')
            || Str::startsWith($url, 'tel:')
            || Str::startsWith($url, 'javascript:');
    }

    private static function isInternalUrl(string $url): bool
    {
        if (Str::startsWith($url, '/')) {
            return !Str::startsWith($url, '//');
        }

        $host = parse_url($url, PHP_URL_HOST);

        if (!$host) {
            return false;
        }

        $siteHost = wp_parse_url(home_url(), PHP_URL_HOST);

        return $siteHost && strcasecmp((string) $host, (string) $siteHost) === 0;
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

    private static function slugForPost(?int $postId, string $url): ?string
    {
        if ($postId !== null && $postId > 0) {
            $frontId = (int) get_option('page_on_front');

            if ($frontId > 0 && $postId === $frontId) {
                return apply_filters('lumina_api_v2_wysiwyg_home_slug', '', $postId, $url);
            }

            $slug = get_post_field('post_name', $postId);

            if (is_string($slug) && $slug !== '') {
                return $slug;
            }
        }

        return self::slugFromUrlPath($url);
    }

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
}
