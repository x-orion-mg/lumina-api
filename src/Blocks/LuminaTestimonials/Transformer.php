<?php

namespace Lumina\ApiV2\Blocks\LuminaTestimonials;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Testimony;

final class Transformer
{
    private const TESTIMONIALS_LIMIT = 5;

    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        $testimonyIds = $data['testimonials'] ?? [];

        /*
         * Sélection manuelle prioritaire.
         *
         * Si aucun témoignage n'est sélectionné,
         * récupération automatique des témoignages récents.
         */
        $testimonials = !empty($testimonyIds)
            ? self::getManualTestimonials($testimonyIds)
            : self::getLatestTestimonials();

        return BlockResponse::make(
            'testimonials',
            [
                'title' => $data['title'] ?? '',

                'testimonials' => $testimonials,
            ]
        );
    }

    /**
     * Témoignages sélectionnés manuellement.
     */
    private static function getManualTestimonials($testimonyIds): array
    {
        if (empty($testimonyIds) || !is_array($testimonyIds)) {
            return [];
        }

        $testimonials = [];

        foreach ($testimonyIds as $testimonyId) {
            $testimony = Testimony::parse($testimonyId);

            if ($testimony === null) {
                continue;
            }

            $testimonials[] = $testimony;

            if (count($testimonials) >= self::TESTIMONIALS_LIMIT) {
                break;
            }
        }

        return $testimonials;
    }

    /**
     * Récupère automatiquement les témoignages les plus récents.
     */
    private static function getLatestTestimonials(): array
    {
        $posts = get_posts([
            'post_type' => 'testimony',

            'post_status' => 'publish',

            'posts_per_page' => self::TESTIMONIALS_LIMIT,

            'orderby' => 'date',

            'order' => 'DESC',
        ]);

        if (empty($posts)) {
            return [];
        }

        $testimonials = [];

        foreach ($posts as $post) {
            $testimony = Testimony::parse($post);

            if ($testimony === null) {
                continue;
            }

            $testimonials[] = $testimony;
        }

        return $testimonials;
    }
}