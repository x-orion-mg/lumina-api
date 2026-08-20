<?php

namespace Lumina\ApiV2\PostTypes\Definitions\Testimony;

class Fields
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public static function fields(): array
    {
        return [
            [
                'key'   => 'field_lumina_testimony_text',
                'label' => 'Témoignage',
                'name'  => 'testimony',
                'type'  => 'textarea',
                'rows'  => 4,
            ],
        ];
    }
}
