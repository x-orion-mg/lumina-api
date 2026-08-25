<?php


namespace Lumina\ApiV2\Helpers;

use WC_Product;

final class Product
{
    /**
     * Normalise un produit WooCommerce pour l'API.
     *
     * Accepte :
     * un objet WC_Product
     * un ID produit
     *
     * Retourne null si le produit est invalide ou non publié.
     */
    public static function parse($value): ?array
    {
        $product = self::resolve($value);

        if (!$product) {
            return null;
        }

        if ($product->get_status() !== 'publish') {
            return null;
        }

        return [
            'id' => (int)$product->get_id(),

            'name' => $product->get_name(),

            'slug' => $product->get_slug(),

            'sku' => $product->get_sku(),

            'url' => $product->get_permalink(),

            'image' => Media::image(
                $product->get_image_id()
            ),

            'price' => $product->get_price(),

            'regular_price' => $product->get_regular_price(),

            'sale_price' => $product->get_sale_price(),

            'on_sale' => $product->is_on_sale(),
        ];
    }

    /**
     * Résout une valeur ACF en objet WC_Product.
     */
    private static function resolve($value): ?WC_Product
    {
        if (empty($value)) {
            return null;
        }

        /*
         * ACF Relationship peut retourner un tableau
         * même lorsqu'un seul produit est sélectionné.
         */
        if (is_array($value)) {
            $value = reset($value);
        }

        /*
         * Produit déjà résolu.
         */
        if ($value instanceof WC_Product) {
            return $value;
        }

        /*
         * ID produit.
         */
        if (is_numeric($value)) {
            $product = wc_get_product((int)$value);

            return $product instanceof WC_Product
                ? $product
                : null;
        }

        return null;
    }
}