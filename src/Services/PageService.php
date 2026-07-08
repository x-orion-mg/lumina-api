<?php


namespace Lumina\ApiV2\Services;

use Lumina\ApiV2\Transformers\PageTransformer;

class PageService
{
    public static function getBySlug(string $slug, ?string $lang = null)
    {
        $lang = LanguageService::normalizeFromRequest($lang);

        return LanguageService::runWithLanguage($lang, function () use ($slug, $lang) {
            $page = get_page_by_path($slug, OBJECT, 'page');

            if (!$page instanceof \WP_Post) {
                return null;
            }

            $page = self::ensurePageInLanguage($page, $lang);

            if (!$page instanceof \WP_Post) {
                return null;
            }

            return PageTransformer::transform($page, $lang);
        });
    }

    /**
     * Si WPML renvoie encore une autre langue (requête non filtrée, doublon de slug, etc.),
     * tente de résoudre la traduction pour la langue demandée.
     */
    private static function ensurePageInLanguage(\WP_Post $page, string $lang): ?\WP_Post
    {
        if (!LanguageService::isWpmlActive()) {
            return $page;
        }

        $pageLang = LanguageService::postLanguageCode((int) $page->ID);

        if ($pageLang !== null && strcasecmp($pageLang, $lang) === 0) {
            return $page;
        }

        $translatedId = LanguageService::translatedObjectId((int) $page->ID, $lang);

        if ($translatedId === null || $translatedId === (int) $page->ID) {
            return $pageLang === null ? $page : null;
        }

        $translated = get_post($translatedId);

        if (!$translated instanceof \WP_Post || $translated->post_type !== 'page') {
            return null;
        }

        return $translated;
    }
}
