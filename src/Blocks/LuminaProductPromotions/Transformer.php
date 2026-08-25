<?php

namespace Lumina\ApiV2\Blocks\LuminaProductPromotions;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Product;

final class Transformer
{
    private const PRODUCTS_LIMIT = 3;

    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        $productIds = $data['products'] ?? [];

        /*
         * Si des produits sont sélectionnés manuellement,
         * ils ont priorité sur la récupération automatique.
         */
        $products = !empty($productIds)
            ? self::getManualProducts($productIds)
            : self::getPromotionProducts();

        return BlockResponse::make(
            'product_promotions',
            [
                'title' => $data['title'] ?? '',

                'products' => $products,
            ]
        );
    }

    /**
     * Produits sélectionnés manuellement.
     */
    private static function getManualProducts($productIds): array
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
     * Récupère automatiquement les produits en promotion.
     */
    private static function getPromotionProducts(): array
    {
        $products = wc_get_products([
            'status' => 'publish',

            'limit' => self::PRODUCTS_LIMIT,

            'on_sale' => true,

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
}