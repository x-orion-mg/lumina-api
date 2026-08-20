<?php

namespace Lumina\ApiV2\PostTypes;

use Lumina\ApiV2\PostTypes\Contracts\PostTypeTransformerInterface;
use Lumina\ApiV2\PostTypes\Transformers\DefaultPostTypeTransformer;

class PostTypeTransformerResolver
{
    /** @var array<string, PostTypeTransformerInterface> */
    private static array $instances = [];

    /**
     * @return array<string, mixed>
     */
    public static function summary(\WP_Post $post, string $lang): array
    {
        return self::resolve($post->post_type)->summary($post, $lang);
    }

    /**
     * @return array<string, mixed>
     */
    public static function detail(\WP_Post $post, string $lang): array
    {
        return self::resolve($post->post_type)->detail($post, $lang);
    }

    public static function resolve(string $postType): PostTypeTransformerInterface
    {
        if (isset(self::$instances[$postType])) {
            return self::$instances[$postType];
        }

        $registry = PostTypeRegistry::instance();
        $transformerClass = $registry->getTransformerClass($postType);

        $transformerClass = apply_filters(
            'lumina_api_v2_post_type_transformer',
            $transformerClass,
            $postType
        );

        if (is_string($transformerClass) && $transformerClass !== '' && class_exists($transformerClass)) {
            $instance = new $transformerClass();

            if ($instance instanceof PostTypeTransformerInterface) {
                self::$instances[$postType] = $instance;

                return $instance;
            }
        }

        self::$instances[$postType] = new DefaultPostTypeTransformer();

        return self::$instances[$postType];
    }
}
