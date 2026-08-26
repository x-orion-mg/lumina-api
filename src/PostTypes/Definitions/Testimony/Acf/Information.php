<?php

namespace Lumina\ApiV2\PostTypes\Definitions\Testimony\Acf;

use Lumina\ApiV2\PostTypes\Acf\AcfGroup;

class Information extends AcfGroup
{
    public static function key(): string
    {
        return 'group_lumina_testimony_information';
    }

    public static function title(): string
    {
        return '[Témoignages] - Informations';
    }

    public static function fields(): array
    {
        return [
            [
                'key' => 'field_lumina_testimony_testimony',
                'label' => 'Témoignage',
                'name' => 'testimony',
                'type' => 'textarea',
                'instructions' => 'Texte du témoignage.',
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

            [
                'key' => 'field_lumina_testimony_job',
                'label' => 'Poste',
                'name' => 'job',
                'type' => 'text',
                'instructions' => 'Poste ou fonction de la personne.',
                'required' => 0,

                'wrapper' => [
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ],

                'default_value' => '',
            ],

            [
                'key' => 'field_lumina_testimony_company',
                'label' => 'Entreprise',
                'name' => 'company',
                'type' => 'text',
                'instructions' => 'Nom de l’entreprise.',
                'required' => 0,

                'wrapper' => [
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ],

                'default_value' => '',
            ],
            [
                'key' => 'field_lumina_testimony_name',
                'label' => 'Nom',
                'name' => 'name',
                'type' => 'text',
                'instructions' => 'Nom de la personne.',
                'required' => 1,

                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],

                'default_value' => '',
            ],
            [
                'key' => 'field_lumina_testimony_profile',
                'label' => 'Photo de profil',
                'name' => 'profile',
                'type' => 'image',
                'instructions' => 'Photo de profil de la personne.',
                'required' => 0,

                'wrapper' => [
                    'width' => '50',
                    'class' => '',
                    'id' => '',
                ],

                'return_format' => 'array',
                'library' => 'all',
                'preview_size' => 'medium',
            ],
        ];
    }
}