<?php

namespace Lumina\ApiV2\PostTypes;

use Lumina\ApiV2\PostTypes\Acf\AcfGroupRegistrar;
use Lumina\ApiV2\PostTypes\Registration\PostTypeRegistrar;

class PostTypeManager
{
    public static function boot(): void
    {
        PostTypeRegistry::instance()->discover();

        add_action(
            'init',
            [PostTypeRegistrar::class, 'register'],
            99
        );

        add_action(
            'acf/include_fields',
            [AcfGroupRegistrar::class, 'registerAll'],
            20
        );
    }
}