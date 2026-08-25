<?php

namespace Lumina\ApiV2\Blocks\LuminaNewProducts;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Product;

final class Transformer
{
    private const PRODUCTS_LIMIT = 8;

    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        $productIds = $data['products'] ?? [];

        /*
         * Sélection manuelle prioritaire.
         *
         * Si aucun produit n'est sélectionné,
         * on récupère automatiquement les nouveautés.
         */
        $products = !empty($productIds)
            ? self::getManualProducts($productIds)
            : self::getNewProducts();

        return BlockResponse::make(
            'new_products',
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
     * Récupère automatiquement les produits les plus récents.
     */
    private static function getNewProducts(): array
    {
        $products = wc_get_products([
            'status' => 'publish',

            'limit' => self::PRODUCTS_LIMIT,

            'orderby' => 'date',

            'order' => 'DESC',
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