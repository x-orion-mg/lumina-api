<?php

namespace Lumina\ApiV2\PostTypes\Contracts;

interface PostTypeTransformerInterface
{
    /**
     * @return array<string, mixed>
     */
    public function summary(\WP_Post $post, string $lang): array;

    /**
     * @return array<string, mixed>
     */
    public function detail(\WP_Post $post, string $lang): array;
}
