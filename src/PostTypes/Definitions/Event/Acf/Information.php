<?php

namespace Lumina\ApiV2\PostTypes\Definitions\Event\Acf;

use Lumina\ApiV2\PostTypes\Acf\AcfGroup;

class Information extends AcfGroup
{
    public static function key(): string
    {
        return 'group_lumina_event_information';
    }

    public static function title(): string
    {
        return '[Événements] - Informations';
    }

    public static function fields(): array
    {
        return [
            [
                'key' => 'field_lumina_event_date',
                'label' => 'Date de l’événement',
                'name' => 'event_date',
                'type' => 'date_picker',
                'display_format' => 'd/m/Y',
                'return_format' => 'Y-m-d',
            ],

            [
                'key' => 'field_lumina_event_location',
                'label' => 'Lieu',
                'name' => 'event_location',
                'type' => 'text',
            ],

            [
                'key' => 'field_lumina_event_description',
                'label' => 'Description courte',
                'name' => 'event_description',
                'type' => 'textarea',
                'rows' => 4,
                'new_lines' => 'br',
            ],

            [
                'key' => 'field_lumina_event_registration_url',
                'label' => 'URL d’inscription',
                'name' => 'event_registration_url',
                'type' => 'url',
            ],
        ];
    }
}