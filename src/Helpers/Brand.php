<?php

namespace Lumina\ApiV2\Helpers;

final class Brand
{
    /**
     * Transforme un témoignage WordPress en objet API.
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
         * Vérifie qu'il s'agit bien d'un témoignage.
         */
        if ($post->post_type !== 'brand') {
            return null;
        }
        $logo = get_field('logo', $post->ID);
        return [
            'id' => (int) $post->ID,

            'post_title' => get_the_title($post->ID),
            'date' => get_the_date(
                'c',
                $post->ID
            ),
            'logo'=>Media::image($logo ?? null),
            'link' => get_field('link', $post->ID),
            'brand_name' => get_field('name', $post->ID),
            'description' => get_field('description', $post->ID),

        ];
    }
}
