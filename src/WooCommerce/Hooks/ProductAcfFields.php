<?php

namespace Lumina\ApiV2\WooCommerce\Hooks;

use Lumina\ApiV2\PostTypes\Acf\AcfGroupRegistrar;

class ProductAcfFields
{
    private const POST_TYPE = 'product';

    public static function register(): void
    {
        add_action('admin_enqueue_scripts', [self::class, 'enqueueScripts']);
        add_action('woocommerce_product_options_general_product_data', [self::class, 'renderFields']);
        add_action('woocommerce_process_product_meta', [self::class, 'saveFields'], 10, 1);
    }

    public static function enqueueScripts(string $hook): void
    {
        if (!in_array($hook, ['post.php', 'post-new.php'], true)) {
            return;
        }

        $screen = function_exists('get_current_screen') ? get_current_screen() : null;

        if (!$screen || $screen->post_type !== self::POST_TYPE) {
            return;
        }

        if (function_exists('acf_enqueue_scripts')) {
            acf_enqueue_scripts();
        }
    }

    public static function renderFields(): void
    {
        if (!function_exists('acf_get_fields') || !function_exists('acf_render_field_wrap')) {
            return;
        }

        global $post;

        if (!$post instanceof \WP_Post || $post->post_type !== self::POST_TYPE) {
            return;
        }

        $fields = acf_get_fields(AcfGroupRegistrar::groupKey(self::POST_TYPE));

        if (!is_array($fields) || $fields === []) {
            return;
        }

        echo '<div class="options_group lumina-wc-product-acf-fields">';
        echo '<p class="form-field"><strong>' . esc_html__('Lumina API v2', 'lumina-api-v2') . '</strong></p>';

        foreach ($fields as $field) {
            if (!is_array($field)) {
                continue;
            }

            acf_render_field_wrap($field, 'div', 'label');
        }

        echo '</div>';
    }

    public static function saveFields(int $postId): void
    {
        if (!function_exists('acf_save_post') || get_post_type($postId) !== self::POST_TYPE) {
            return;
        }

        if (!isset($_POST['acf']) || !is_array($_POST['acf'])) {
            return;
        }

        acf_save_post($postId);
    }
}
