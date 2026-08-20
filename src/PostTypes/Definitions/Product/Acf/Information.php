<?php

namespace Lumina\ApiV2\PostTypes\Definitions\Product\Acf;

use Lumina\ApiV2\PostTypes\Acf\AcfGroup;

class Information extends AcfGroup
{
    public static function key(): string
    {
        return 'group_lumina_product_information';
    }

    public static function title(): string
    {
        return '[Produits] - Informations';
    }

    public static function fields(): array
    {
        return [
            [
                'key' => 'field_lumina_product_youtube_url',
                'label' => 'Lien vidéo YouTube',
                'name' => 'youtube_video_url',
                'aria-label' => '',
                'type' => 'link',
                'instructions' => 'URL complète de la vidéo YouTube (ex. https://www.youtube.com/watch?v=…).',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],
                'return_format' => 'array',
                'allow_in_bindings' => 0,
            ],

            [
                'key' => 'field_lumina_product_legrand_url',
                'label' => 'Lien produit Legrand',
                'name' => 'legrand_product_url',
                'aria-label' => '',
                'type' => 'link',
                'instructions' => 'URL de la fiche produit sur le site Legrand.',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],
                'return_format' => 'array',
                'allow_in_bindings' => 0,
            ],

            [
                'key' => 'field_lumina_product_technical_specs',
                'label' => 'Caractéristiques techniques',
                'name' => 'technical_specs',
                'aria-label' => '',
                'type' => 'wysiwyg',
                'instructions' => 'Tableau ou liste des caractéristiques techniques du produit.',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],
                'default_value' => '',
                'allow_in_bindings' => 0,
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ],
        ];
    }
}