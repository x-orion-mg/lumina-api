<?php

namespace Lumina\ApiV2\Acf;

class IconField
{
    public const FIELD_NAME = 'icon_lumina';

    public static function init(): void
    {
        add_filter('acf/load_field/name=' . self::FIELD_NAME, [self::class, 'loadField']);
        add_action('acf/render_field/name=' . self::FIELD_NAME, [self::class, 'renderPreview'], 10, 1);
        add_action('acf/input/admin_enqueue_scripts', [self::class, 'enqueueAssets']);
    }

    /**
     * @param array<string, mixed> $field
     * @return array<string, mixed>
     */
    public static function loadField(array $field): array
    {
        $field['choices'] = IconRegistry::choices();
        $field['ui'] = 1;
        $field['ajax'] = 0;
        $field['allow_null'] = $field['allow_null'] ?? 1;
        $field['placeholder'] = $field['placeholder'] ?? '— Choisir une icône —';

        return $field;
    }

    /**
     * @param array<string, mixed> $field
     */
    public static function renderPreview(array $field): void
    {
        $value = $field['value'] ?? '';
        $resolved = IconRegistry::resolve(is_string($value) ? $value : '');

        $url = $resolved['url'] ?? '';
        $label = $resolved['label'] ?? '';

        printf(
            '<div class="lumina-icon-preview" data-lumina-icon-preview data-icon-url="%s" data-icon-label="%s">',
            esc_attr($url),
            esc_attr($label)
        );

        if ($url !== '') {
            printf(
                '<img src="%s" alt="%s" width="40" height="40" />',
                esc_url($url),
                esc_attr($label)
            );
            printf('<span class="lumina-icon-preview__label">%s</span>', esc_html($label));
        } else {
            echo '<span class="lumina-icon-preview__empty">' . esc_html__('Aucune icône sélectionnée', 'lumina-api-v2') . '</span>';
        }

        echo '</div>';
    }

    public static function enqueueAssets(): void
    {
        if (!function_exists('acf_get_setting')) {
            return;
        }

        $base = LUMINA_API_V2_URL . 'assets/admin/';

        wp_enqueue_style(
            'lumina-icon-field',
            $base . 'icon-field.css',
            [],
            '1.0.0'
        );

        wp_enqueue_script(
            'lumina-icon-field',
            $base . 'icon-field.js',
            ['jquery', 'acf-input'],
            '1.0.0',
            true
        );

        wp_localize_script('lumina-icon-field', 'luminaIcons', IconRegistry::forAdmin());
    }
}
