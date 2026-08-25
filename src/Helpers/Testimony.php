<?php

namespace Lumina\ApiV2\Helpers;

final class Testimony
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
        if ($post->post_type !== 'testimony') {
            return null;
        }

        return [
            'id' => (int) $post->ID,

            'title' => get_the_title($post->ID),

            'content' => apply_filters(
                'the_content',
                $post->post_content
            ),

            'author' => get_the_author_meta(
                'display_name',
                $post->post_author
            ),

            'date' => get_the_date(
                'c',
                $post->ID
            ),
        ];
    }
}
