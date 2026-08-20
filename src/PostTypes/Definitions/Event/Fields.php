<?php

namespace Lumina\ApiV2\PostTypes\Definitions\Event;

class Fields
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public static function fields(): array
    {
        return [
            [
                'key'            => 'field_lumina_event_date',
                'label'          => 'Date de l’événement',
                'name'           => 'event_date',
                'type'           => 'date_picker',
                'display_format' => 'd/m/Y',
                'return_format'  => 'Y-m-d',
            ],
            [
                'key'   => 'field_lumina_event_location',
                'label' => 'Lieu',
                'name'  => 'event_location',
                'type'  => 'text',
            ],
            [
                'key'          => 'field_lumina_event_description',
                'label'        => 'Description courte',
                'name'         => 'event_description',
                'type'         => 'textarea',
                'rows'         => 4,
                'new_lines'    => 'br',
            ],
            [
                'key'   => 'field_lumina_event_registration_url',
                'label' => 'URL d’inscription',
                'name'  => 'event_registration_url',
                'type'  => 'url',
            ],
        ];
    }
}
