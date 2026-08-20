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
                'key'   => 'field_lumina_testimony_text',
                'label' => 'Témoignage',
                'name'  => 'testimony',
                'type'  => 'textarea',
                'rows'  => 4,
            ],
        ];
    }
}