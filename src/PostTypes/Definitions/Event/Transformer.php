<?php

namespace Lumina\ApiV2\PostTypes\Definitions\Event;

use Lumina\ApiV2\Helpers\Button;
use Lumina\ApiV2\PostTypes\Contracts\PostTypeTransformerInterface;
use Lumina\ApiV2\PostTypes\Transformers\DefaultPostTypeTransformer;

class Transformer implements PostTypeTransformerInterface
{
    private DefaultPostTypeTransformer $default;

    public function __construct()
    {
        $this->default = new DefaultPostTypeTransformer();
    }

    /**
     * @return array<string, mixed>
     */
    public function summary(\WP_Post $post, string $lang): array
    {
        $data = $this->default->summary($post, $lang);
        $data['event_date'] = function_exists('get_field') ? (get_field('event_date', $post->ID) ?: '') : '';

        return $data;
    }

    /**
     * @return array<string, mixed>
     */
    public function detail(\WP_Post $post, string $lang): array
    {
        $data = $this->default->detail($post, $lang);

        $data['event'] = [
            'date'             => function_exists('get_field') ? (get_field('event_date', $post->ID) ?: '') : '',
            'location'         => function_exists('get_field') ? (get_field('event_location', $post->ID) ?: '') : '',
            'description'      => function_exists('get_field') ? (get_field('event_description', $post->ID) ?: '') : '',
            'registration_url' => Button::parse(function_exists('get_field') ? get_field('event_registration_url', $post->ID) : null),
        ];

        return $data;
    }
}
