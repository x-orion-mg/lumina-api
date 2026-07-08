<?php

namespace Lumina\ApiV2\Services;

/**
 * Langue de l’API et bascule WPML pour les lectures (pages, options ACF, etc.).
 */
class LanguageService
{
    public static function isWpmlActive(): bool
    {
        return defined('ICL_SITEPRESS_VERSION')
            || defined('ICL_LANGUAGE_CODE')
            || class_exists('SitePress', false);
    }

    /**
     * Langue par défaut du site (WPML si actif, sinon fallback).
     */
    public static function getDefault(): string
    {
        if (self::isWpmlActive() && function_exists('apply_filters')) {
            $def = apply_filters('wpml_default_language', null);

            if (is_string($def) && $def !== '') {
                return self::normalizeCode($def);
            }
        }

        return 'fr';
    }

    /**
     * Code langue issu de l’URL REST, normalisé pour WPML.
     */
    public static function normalizeFromRequest(?string $lang): string
    {
        if ($lang === null || $lang === '') {
            return self::getDefault();
        }

        return self::normalizeCode($lang);
    }

    /**
     * Normalise un code langue (minuscule, caractères autorisés type WPML : fr, en, pt-br, zh-hans).
     */
    public static function normalizeCode(string $code): string
    {
        $code = strtolower(trim($code));
        $code = preg_replace('/[^a-z0-9_-]/', '', $code) ?? '';

        return $code !== '' ? $code : self::getDefault();
    }

    /**
     * Exécute un callback avec la langue WPML active temporairement fixée à $lang,
     * puis restaure la langue précédente (ou la langue par défaut du site).
     *
     * @template T
     * @param callable(): T $callback
     * @return T
     */
    public static function runWithLanguage(string $lang, callable $callback)
    {
        $lang = self::normalizeCode($lang);

        if (!self::isWpmlActive() || !function_exists('do_action') || !function_exists('apply_filters')) {
            return $callback();
        }

        $previous = apply_filters('wpml_current_language', null);
        $previous = is_string($previous) && $previous !== '' ? $previous : null;

        /**
         * ACF lit la langue « courante » via ce filtre pour les options (et autres résolutions).
         * Sans cela, get_fields('option') reste souvent sur la langue par défaut malgré WPML.
         * Équivalent du thème : add_filter( 'acf/settings/current_language', 'cl_acf_set_language', 100 ).
         */
        $acfLangFilter = static function () use ($lang): string {
            return $lang;
        };

        $acfHooked = function_exists('add_filter')
            && (function_exists('acf_get_setting') || class_exists('ACF', false));

        if ($acfHooked) {
            add_filter('acf/settings/current_language', $acfLangFilter, 100);
        }

        do_action('wpml_switch_language', $lang);

        try {
            return $callback();
        } finally {
            if ($acfHooked) {
                remove_filter('acf/settings/current_language', $acfLangFilter, 100);
            }

            $restore = $previous ?? apply_filters('wpml_default_language', null);
            $restore = is_string($restore) && $restore !== '' ? $restore : self::getDefault();

            do_action('wpml_switch_language', $restore);
        }
    }

    /**
     * Langue WPML du post (null si inconnu / WPML inactif).
     */
    public static function postLanguageCode(int $postId): ?string
    {
        if (!self::isWpmlActive() || !function_exists('apply_filters')) {
            return null;
        }

        $details = apply_filters('wpml_post_language_details', null, $postId);

        if (is_array($details) && !empty($details['language_code']) && is_string($details['language_code'])) {
            return self::normalizeCode($details['language_code']);
        }

        return null;
    }

    /**
     * ID de la traduction WPML d’un contenu pour une langue cible (ou null).
     */
    public static function translatedObjectId(int $postId, string $targetLang, string $postType = 'page'): ?int
    {
        if (!self::isWpmlActive() || !function_exists('apply_filters')) {
            return null;
        }

        $targetLang = self::normalizeCode($targetLang);
        // false = ne pas renvoyer l’ID d’origine si la traduction n’existe pas
        $translated = (int) apply_filters('wpml_object_id', $postId, $postType, false, $targetLang);

        return $translated > 0 ? $translated : null;
    }
}
