<?php

namespace Lumina\ApiV2\Blocks\Partners;

use Lumina\ApiV2\Helpers\AcfBlockData;
use Lumina\ApiV2\Helpers\BlockResponse;
use Lumina\ApiV2\Helpers\Media;

class Transformer
{
    public static function transform(array $block): array
    {
        $data = AcfBlockData::extract($block);

        $partners = array_filter(
            array_map(
                static function ($partnerId) {

                    $post = get_post($partnerId);

                    if (
                        !$post
                        || $post->post_status !== 'publish'
                    ) {
                        return null;
                    }

                    $logoId = get_field('logo_partner', $partnerId);

                    $thumbnailId = get_post_thumbnail_id($partnerId);

                    return [
                        'title' => $post->post_title ?? '',
                        'link' => get_field('lien_partner', $partnerId) ?? '',
                        'logo' => Media::image($logoId),
                        'thumbnail' => Media::image($thumbnailId),
                    ];

                },
                $data['list_of_partners'] ?? []
            )
        );

        return BlockResponse::make('partners', [

            'title' => $data['title'] ?? '',

            'list_of_partners' => array_values($partners),

        ]);
    }
}