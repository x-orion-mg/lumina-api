<?php

namespace Lumina\ApiV2\Blocks\TeamTestimonials;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Media;

class Transformer
{
    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        $clients = array_values(array_filter(
            array_map(
                static function ($clientId) {

                    $post = get_post($clientId);

                    if (
                        !$post ||
                        $post->post_status !== 'publish'
                    ) {
                        return null;
                    }

                    $profilePhotoId = get_field('profile_photo', $clientId);

                    return [
                        'title'               => $post->post_title ?? '',
                        'profile_photo'       => Media::image($profilePhotoId),
                        'first_and_last_name' => get_field('first_and_last_name', $clientId) ?? '',
                        'company'             => get_field('company', $clientId) ?? '',
                        'function'            => get_field('function', $clientId) ?? '',
                        'testimonial'         => get_field('testimony', $clientId) ?? '',
                    ];
                },
                $data['list_of_clients'] ?? []
            )
        ));

        return BlockResponse::make('team_testimonials', [
            'eyebrow' => $data['badge'] ?? '',
            'title'   => $data['title'] ?? '',
            'clients' => $clients,
        ]);
    }
}