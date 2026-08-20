<?php

namespace Lumina\ApiV2\PostTypes\Definitions\Product;

class Fields
{
    /**
     * Champs ACF pour les fiches produit WooCommerce.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function fields(): array
    {
        return [
            [
                'key'          => 'field_lumina_product_youtube_url',
                'label'        => 'Lien vidéo YouTube',
                'name'         => 'youtube_video_url',
                'type'         => 'url',
                'instructions' => 'URL complète de la vidéo YouTube (ex. https://www.youtube.com/watch?v=…).',
                'placeholder'  => 'https://www.youtube.com/watch?v=',
            ],
            [
                'key'          => 'field_lumina_product_legrand_url',
                'label'        => 'Lien produit Legrand',
                'name'         => 'legrand_product_url',
                'type'         => 'url',
                'instructions' => 'URL de la fiche produit sur le site Legrand.',
                'placeholder'  => 'https://www.legrand.fr/',
            ],
            [
                'key'          => 'field_lumina_product_technical_specs',
                'label'        => 'Caractéristiques techniques',
                'name'         => 'technical_specs',
                'type'         => 'wysiwyg',
                'instructions' => 'Tableau ou liste des caractéristiques techniques du produit.',
                'tabs'         => 'all',
                'toolbar'      => 'full',
                'media_upload' => 0,
                'delay'        => 0,
            ],
        ];
    }
}
