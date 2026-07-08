<?php

namespace Lumina\ApiV2\Helpers;

use Lumina\ApiV2\Services\LanguageService;

/**
 * Helper pour récupérer les slugs d'un post dans toutes les langues disponibles.
 */
class MultilingualSlug
{
    /**
     * Récupère les slugs d'un post dans toutes les langues disponibles.
     * 
     * @param int $postId ID du post
     * @param string $currentLang Langue courante
     * @param string $postType Type du post
     * @return array{current: string, [lang]: string}
     */
    public static function getAllTranslationsSlugs(int $postId, string $currentLang, string $postType = 'page'): array
    {
        if (!LanguageService::isWpmlActive() || !function_exists('apply_filters')) {
            return [
                'current' => $currentLang,
                $currentLang => get_post_field('post_name', $postId),
            ];
        }

        $currentLang = LanguageService::normalizeCode($currentLang);
        $slugs = [
            'current' => $currentLang,
        ];

        // Récupérer toutes les langues actives WPML
        $activeLanguages = apply_filters('wpml_active_languages', null, 'skip_missing=0');

        if (!is_array($activeLanguages) || $activeLanguages === []) {
            $slugs[$currentLang] = get_post_field('post_name', $postId);
            return $slugs;
        }

        foreach ($activeLanguages as $langCode => $langData) {
            $normalizedLang = LanguageService::normalizeCode($langCode);
            
            // Récupérer l'ID du post traduit
            $translatedId = LanguageService::translatedObjectId($postId, $normalizedLang, $postType);
            
            if ($translatedId !== null) {
                $translatedPost = get_post($translatedId);
                if ($translatedPost instanceof \WP_Post) {
                    $slugs[$normalizedLang] = $translatedPost->post_name;
                }
            }
        }

        return $slugs;
    }
}
