<?php

namespace Lumina\ApiV2\PostTypes\Contracts;

use Lumina\ApiV2\PostTypes\PostTypeDefinition;

interface PostTypeDefinitionProvider
{
    public static function create(): PostTypeDefinition;
}
