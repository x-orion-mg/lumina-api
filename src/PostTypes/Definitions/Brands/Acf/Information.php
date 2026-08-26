<?php

namespace Lumina\ApiV2\PostTypes\Definitions\Brands\Acf;

use Lumina\ApiV2\PostTypes\Acf\AcfGroup;

class Information extends AcfGroup
{
    public static function key(): string
    {
        return 'group_lumina_brand_information';
    }

    public static function title(): string
    {
        return '[Marques] - Informations';
    }

    public static function fields(): array
    {
        return [
            [
                'key' => 'field_lumina_brands_logo',
                'label' => 'Logo',
                'name' => 'logo',
                'type' => 'image',
                'instructions' => 'Logo de la marque.',
                'required' => 1,

                'wrapper' => [
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ],

                'return_format' => 'array',
                'library' => 'all',
                'preview_size' => 'medium',
            ],

            [
                'key' => 'field_lumina_brands_name',
                'label' => 'Nom de la marque',
                'name' => 'name',
                'type' => 'text',
                'instructions' => 'Nom de la marque.',
                'required' => 1,

                'wrapper' => [
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ],

                'default_value' => '',
            ],

            [
                'key' => 'field_lumina_brands_link',
                'label' => 'Lien vers la marque',
                'name' => 'link',
                'type' => 'link',
                'instructions' => 'URL du site ou de la page de la marque.',
                'required' => 0,

                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],

                'default_value' => '',
            ],
            [
                'key' => 'field_lumina_brand_description',
                'label' => 'Description',
                'name' => 'description',
                'type' => 'textarea',
                'instructions' => 'Description de la marque.',
                'required' => 1,

                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],

                'default_value' => '',
                'rows' => 6,
                'new_lines' => 'br',
            ],
        ];
    }
}