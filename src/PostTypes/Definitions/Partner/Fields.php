<?php

namespace Lumina\ApiV2\PostTypes\Definitions\Partner;

class Fields
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public static function fields(): array
    {
        return [
            [
                'key'           => 'field_lumina_partner_logo',
                'label'         => 'Logo',
                'name'          => 'logo_partner',
                'type'          => 'image',
                'return_format' => 'array',
                'preview_size'  => 'medium',
            ],
            [
                'key'   => 'field_lumina_partner_link',
                'label' => 'Lien',
                'name'  => 'lien_partner',
                'type'  => 'url',
            ],
        ];
    }
}
