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
        $profile = get_field('profile', $post->ID);
        return [
            'id' => (int) $post->ID,

            'post_title' => get_the_title($post->ID),


            'date' => get_the_date(
                'c',
                $post->ID
            ),
            'name'=> get_field('name', $post->ID),
            'testimony' => get_field('testimony', $post->ID),
            'job' => get_field('job', $post->ID),
            'company' => get_field('company', $post->ID),
            'profile' => Media::image($profile ?? null),
        ];
    }
}
