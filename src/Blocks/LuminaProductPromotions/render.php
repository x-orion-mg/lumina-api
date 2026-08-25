<?php

/**
 * @param array  $block
 * @param string $content
 * @param bool   $is_preview
 * @param int    $post_id
 */

$is_block_preview = $is_preview || !empty($block['data']['is_preview']);

if ($is_block_preview) {
    $preview_png = __DIR__ . '/preview.png';
    $preview_svg = __DIR__ . '/preview.svg';

    if (file_exists($preview_png)) {
        echo '<img src="' . esc_url(plugin_dir_url(__FILE__) . 'preview.png') . '" alt="" style="width:100%;height:auto;display:block;" />';
        return;
    }

    if (file_exists($preview_svg)) {
        echo '<img src="' . esc_url(plugin_dir_url(__FILE__) . 'preview.svg') . '" alt="" style="width:100%;height:auto;display:block;" />';
        return;
    }

    ?>
    <div style="display:block;width:100%;">
        <div style="background:linear-gradient(135deg,#1e3a5f 0%,#2d5a87 100%);color:#fff;padding:3rem 2rem;text-align:center;border-radius:4px;">
            <p style="margin:0 0 .5rem;font-size:.75rem;text-transform:uppercase;letter-spacing:.1em;opacity:.85;">Lumina</p>
            <h2 style="margin:0;font-size:1.5rem;font-weight:600;">Hero Section</h2>
            <p style="margin:1rem 0 0;font-size:.875rem;opacity:.9;">Prévisualisation du block Hero</p>
        </div>
    </div>
    <?php
    return;
}

$title = get_field('title');
$image = get_field('image');
$image_url = is_array($image) ? ($image['url'] ?? '') : '';
$image_alt = is_array($image) ? ($image['alt'] ?? '') : '';

?>
<section class="be-hero" style="padding:2rem;background:#f5f5f5;border:1px dashed #ccc;">
    <?php if ($image_url) : ?>
        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" style="max-width:100%;height:auto;margin-bottom:1rem;" />
    <?php endif; ?>
    <?php if ($title) : ?>
        <h2 style="margin:0;font-size:1.75rem;"><?php echo esc_html($title); ?></h2>
    <?php else : ?>
        <p style="margin:0;color:#666;"><?php esc_html_e('Ajoutez un titre et une image dans le panneau de droite.', 'lumina-api-v2'); ?></p>
    <?php endif; ?>
</section>