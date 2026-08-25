<?php

namespace Lumina\ApiV2\Helpers;

final class Article
{
    /**
     * Transforme un article WordPress en objet API.
     *
     * @param int|\WP_Post|null $post
     */
    public static function parse($post): ?array
    {
        if (empty($post)) {
            return null;
        }

        /*
         * Accepte un ID ou un WP_Post.
         */
        if (is_numeric($post)) {
            $post = get_post((int) $post);
        }

        if (!$post instanceof \WP_Post) {
            return null;
        }

        /*
         * On s'assure qu'il s'agit bien d'un article.
         */
        if ($post->post_type !== 'post') {
            return null;
        }

        /*
         * Image mise en avant.
         */
        $image = null;

        if (has_post_thumbnail($post->ID)) {
            $image = Media::image(
                get_post_thumbnail_id($post->ID)
            );
        }

        /*
         * Catégories.
         */
        $categories = get_the_category($post->ID);

        $category = null;

        if (!empty($categories)) {
            $term = $categories[0];

            $category = [
                'id' => (int) $term->term_id,
                'name' => $term->name,
                'slug' => $term->slug,
            ];
        }

        return [
            'id' => (int) $post->ID,

            'title' => get_the_title($post->ID),

            'slug' => $post->post_name,

            'url' => get_permalink($post->ID),

            'image' => $image,

            'category' => $category,
        ];
    }
}