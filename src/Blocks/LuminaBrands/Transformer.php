<?php

namespace Lumina\ApiV2\Blocks\LuminaBrands;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Brand;
use Lumina\ApiV2\Helpers\Testimony;

final class Transformer
{
    private const BRANDS_LIMIT = 10;

    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        $brandIds = $data['brands'] ?? [];

        /*
         * Sélection manuelle prioritaire.
         *
         * Si aucune marque n'est sélectionnée,
         * récupération automatique des marques récentes.
         */
        $brands = !empty($brandIds)
            ? self::getManualBrands($brandIds)
            : self::getLatestBrands();

        return BlockResponse::make(
            'brands',
            [
                'title' => $data['title'] ?? '',

                'brands' => $brands,
            ]
        );
    }

    /**
     * Marques sélectionnées manuellement.
     */
    private static function getManualBrands($brandIds): array
    {
        if (empty($brandIds) || !is_array($brandIds)) {
            return [];
        }

        $brands = [];

        foreach ($brandIds as $brandId) {
            $brand = Brand::parse($brandId);

            if ($brand === null) {
                continue;
            }

            $brands[] = $brand;

            if (count($brands) >= self::BRANDS_LIMIT) {
                break;
            }
        }

        return $brands;
    }

    /**
     * Récupère automatiquement les témoignages les plus récents.
     */
    private static function getLatestBrands(): array
    {
        $posts = get_posts([
            'post_type' => 'brand',

            'post_status' => 'publish',

            'posts_per_page' => self::BRANDS_LIMIT,

            'orderby' => 'date',

            'order' => 'DESC',
        ]);

        if (empty($posts)) {
            return [];
        }

        $brands = [];

        foreach ($posts as $post) {
            $brand = Brand::parse($post);

            if ($brand === null) {
                continue;
            }

            $brands[] = $brand;
        }

        return $brands;
    }
}