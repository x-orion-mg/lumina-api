<?php

namespace Lumina\ApiV2\Blocks\LuminaDocumentation;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Article;
use Lumina\ApiV2\Helpers\Button;

final class Transformer
{
    private const ARTICLES_LIMIT = 3;

    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        $articleIds = $data['articles'] ?? [];

        /*
         * Sélection manuelle prioritaire.
         *
         * Si aucun article n'est sélectionné,
         * récupération automatique des articles récents.
         */
        $articles = !empty($articleIds)
            ? self::getManualArticles($articleIds)
            : self::getLatestArticles();

        return BlockResponse::make(
            'documentation',
            [
                'subtitle' => $data['subtitle'] ?? '',

                'title' => $data['title'] ?? '',

                'articles' => $articles,

                'cta' => Button::parse(
                    $data['lumina_documentation_button'] ?? null
                ),
            ]
        );
    }

    /**
     * Articles sélectionnés manuellement.
     */
    private static function getManualArticles($articleIds): array
    {
        if (empty($articleIds) || !is_array($articleIds)) {
            return [];
        }

        $articles = [];

        foreach ($articleIds as $articleId) {
            $article = Article::parse($articleId);

            if ($article === null) {
                continue;
            }

            $articles[] = $article;

            if (count($articles) >= self::ARTICLES_LIMIT) {
                break;
            }
        }

        return $articles;
    }

    /**
     * Récupère automatiquement les articles les plus récents.
     */
    private static function getLatestArticles(): array
    {
        $posts = get_posts([
            'post_type' => 'post',

            'post_status' => 'publish',

            'posts_per_page' => self::ARTICLES_LIMIT,

            'orderby' => 'date',

            'order' => 'DESC',
        ]);

        if (empty($posts)) {
            return [];
        }

        $articles = [];

        foreach ($posts as $post) {
            $article = Article::parse($post);

            if ($article === null) {
                continue;
            }

            $articles[] = $article;
        }

        return $articles;
    }
}