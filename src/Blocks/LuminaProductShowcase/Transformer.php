<?php

namespace Lumina\ApiV2\Blocks\LuminaProductShowcase;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\AcfRepeater;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Media;
use Lumina\ApiV2\Helpers\Product;

final class Transformer
{
    private const PRODUCTS_LIMIT = 6;

    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        $tabs = AcfRepeater::parseFromBlockData(
            $data,
            'tabs',
            [
                'label',
                'source_type',
                'taxonomies',
                'products',
            ],
            static function (array $item): array {
                $sourceType = $item['source_type'] ?? 'taxonomy';

                return [
                    'label' => $item['label'] ?? '',
                    'source_type' => $sourceType,
                    'products' => $sourceType === 'products'
                        ? self::getProductsFromIds($item['products'] ?? [])
                        : self::getProductsFromTaxonomies($item['taxonomies'] ?? []),
                ];
            }
        );

        return BlockResponse::make(
            'lumina_product_showcase',
            [
                'title' => $data['title'] ?? '',
                'tabs' => $tabs,
            ]
        );
    }

    /**
     * Récupère les produits sélectionnés manuellement dans ACF.
     */
    private static function getProductsFromIds($productIds): array
    {
        if (empty($productIds) || !is_array($productIds)) {
            return [];
        }

        $products = [];

        foreach ($productIds as $productId) {
            $product = wc_get_product((int) $productId);

            if (!$product) {
                continue;
            }

            if ($product->get_status() !== 'publish') {
                continue;
            }

            $products[] = Product::parse($product);

            if (count($products) >= self::PRODUCTS_LIMIT) {
                break;
            }
        }

        return $products;
    }

    /**
     * Récupère les produits appartenant aux catégories sélectionnées.
     */
    private static function getProductsFromTaxonomies($taxonomyIds): array
    {
        if (empty($taxonomyIds) || !is_array($taxonomyIds)) {
            return [];
        }

        $taxonomyIds = array_map('intval', $taxonomyIds);
        $taxonomyIds = array_filter($taxonomyIds);

        if (empty($taxonomyIds)) {
            return [];
        }

        $products = wc_get_products([
            'status' => 'publish',
            'limit' => self::PRODUCTS_LIMIT,
            'product_category_id' => $taxonomyIds,
            'orderby' => 'menu_order',
            'order' => 'ASC',
        ]);

        if (empty($products)) {
            return [];
        }

        return array_map(
            static function ($product): array {
                return Product::parse($product);
            },
            $products
        );
    }

}