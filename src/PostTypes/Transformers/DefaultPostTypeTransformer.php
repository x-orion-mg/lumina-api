<?php

namespace Lumina\ApiV2\PostTypes\Transformers;

use Lumina\ApiV2\PostTypes\Contracts\PostTypeTransformerInterface;
use Lumina\ApiV2\PostTypes\PostTypeRegistry;
use Lumina\ApiV2\Transformers\PostContentTransformer;

class DefaultPostTypeTransformer implements PostTypeTransformerInterface
{
    /**
     * @return array<string, mixed>
     */
    public function summary(\WP_Post $post, string $lang): array
    {
        return PostContentTransformer::summary($post, $lang);
    }

    /**
     * @return array<string, mixed>
     */
    public function detail(\WP_Post $post, string $lang): array
    {
        return PostContentTransformer::detail($post, $lang);
    }
}
