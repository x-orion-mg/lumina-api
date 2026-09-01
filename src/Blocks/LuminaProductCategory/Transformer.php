<?php

namespace Lumina\ApiV2\Blocks\LuminaProductCategory;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Button;
use Lumina\ApiV2\Helpers\Media;
use Lumina\ApiV2\Helpers\Product;

final class Transformer
{
    private const PRODUCTS_LIMIT = 4;

    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        $sourceType = $data['source_type'] ?? 'taxonomy';

        $products = $sourceType === 'products'
            ? self::getProductsFromSelection(
                $data['products'] ?? []
            )
            : self::getProductsFromTaxonomy(
                $data['taxonomy'] ?? null
            );

        return BlockResponse::make(
            'product_category',
            [
                'title' => $data['title'] ?? '',
                'color' => $data['color'] ?? '',

                'source_type' => $sourceType,

                'taxonomy' => $sourceType === 'taxonomy'
                    ? self::transformTaxonomy(
                        $data['taxonomy'] ?? null
                    )
                    : null,

                'featured' => [
                    'product' => Product::parse(
                        $data['featured_product'] ?? null
                    ),

                    'subtitle' => $data['featured_subtitle'] ?? '',

                    'title' => $data['featured_title'] ?? '',

                    'image' => Media::image(
                        $data['featured_image'] ?? null
                    ),

                    'cta' => Button::parse(
                        $data['featured_lumina_product_category_featured_button'] ?? null
                    ),
                ],


                'products' => $products,
            ]
        );
    }

    /**
     * Produits sélectionnés manuellement.
     */
    private static function getProductsFromSelection($productIds): array
    {
        if (empty($productIds) || !is_array($productIds)) {
            return [];
        }

        $products = [];

        foreach ($productIds as $productId) {
            $product = Product::parse($productId);

            if ($product === null) {
                continue;
            }

            $products[] = $product;

            if (count($products) >= self::PRODUCTS_LIMIT) {
                break;
            }
        }

        return $products;
    }

    /**
     * Produits récupérés depuis une catégorie WooCommerce.
     */
    private static function getProductsFromTaxonomy($taxonomy): array
    {
        $taxonomyId = self::resolveTaxonomyId($taxonomy);

        if (!$taxonomyId) {
            return [];
        }

        $products = wc_get_products([
            'status' => 'publish',

            'limit' => self::PRODUCTS_LIMIT,

            'product_category_id' => [
                $taxonomyId,
            ],

            'orderby' => 'menu_order',

            'order' => 'ASC',
        ]);

        if (empty($products)) {
            return [];
        }

        $result = [];

        foreach ($products as $product) {
            $parsed = Product::parse($product);

            if ($parsed === null) {
                continue;
            }

            $result[] = $parsed;
        }

        return $result;
    }

    /**
     * Résout l'ID de la catégorie.
     */
    private static function resolveTaxonomyId($taxonomy): ?int
    {
        if (empty($taxonomy)) {
            return null;
        }

        if (is_array($taxonomy)) {
            $taxonomy = reset($taxonomy);
        }

        if (!is_numeric($taxonomy)) {
            return null;
        }

        $taxonomyId = (int) $taxonomy;

        return $taxonomyId > 0
            ? $taxonomyId
            : null;
    }

    /**
     * Transforme la catégorie WooCommerce.
     */
    private static function transformTaxonomy($taxonomy): ?array
    {
        $taxonomyId = self::resolveTaxonomyId($taxonomy);

        if (!$taxonomyId) {
            return null;
        }

        $term = get_term(
            $taxonomyId,
            'product_cat'
        );

        if (!$term || is_wp_error($term)) {
            return null;
        }

        return [
            'id' => (int) $term->term_id,
            'name' => $term->name,
            'slug' => $term->slug,
        ];
    }
}