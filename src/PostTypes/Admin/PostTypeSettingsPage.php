<?php

namespace Lumina\ApiV2\PostTypes\Admin;

use Lumina\ApiV2\Core\Config;
use Lumina\ApiV2\PostTypes\PostTypeRegistry;
use Lumina\ApiV2\PostTypes\PostTypeRepository;

class PostTypeSettingsPage
{
    private const PAGE_SLUG = Config::OPTIONS_SLUG_POST_TYPES;
    private const NONCE_ACTION = 'lumina_post_types_save';

    public static function render(): void
    {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('You do not have sufficient permissions to access this page.', 'lumina-api-v2'));
        }

        if (
            isset($_POST['lumina_post_types_submit'])
            && check_admin_referer(self::NONCE_ACTION)
        ) {
            self::handleSave();
        }

        $registry = PostTypeRegistry::instance();
        $registry->discover();
        $definitions = $registry->all();

        uasort($definitions, static function ($a, $b) {
            return strcasecmp($a->getLabel(), $b->getLabel());
        });

        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <p><?php esc_html_e('Activez ou désactivez les Post Types gérés par Lumina API v2. La désactivation n’efface aucune donnée existante.', 'lumina-api-v2'); ?></p>

            <?php if (isset($_GET['updated']) && $_GET['updated'] === '1') : ?>
                <div class="notice notice-success is-dismissible">
                    <p><?php esc_html_e('Configuration enregistrée.', 'lumina-api-v2'); ?></p>
                </div>
            <?php endif; ?>

            <?php if ($definitions === []) : ?>
                <div class="notice notice-warning">
                    <p><?php esc_html_e('Aucune définition de Post Type trouvée dans src/PostTypes/Definitions/.', 'lumina-api-v2'); ?></p>
                </div>
            <?php endif; ?>

            <form method="post" action="">
                <?php wp_nonce_field(self::NONCE_ACTION); ?>

                <table class="widefat striped" style="max-width:960px;">
                    <thead>
                        <tr>
                            <th><?php esc_html_e('Post Type', 'lumina-api-v2'); ?></th>
                            <th><?php esc_html_e('Key', 'lumina-api-v2'); ?></th>
                            <th><?php esc_html_e('Slug', 'lumina-api-v2'); ?></th>
                            <th><?php esc_html_e('API', 'lumina-api-v2'); ?></th>
                            <th><?php esc_html_e('Statut', 'lumina-api-v2'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($definitions as $definition) :
                            $key = $definition->getKey();
                            $enabled = PostTypeRepository::isEnabled($key);
                            $apiLabel = $definition->isApiEnabled() ? __('Oui', 'lumina-api-v2') : __('Non', 'lumina-api-v2');
                            ?>
                            <tr>
                                <td>
                                    <strong><?php echo esc_html($definition->getLabel()); ?></strong>
                                    <?php if ($definition->getDescription() !== '') : ?>
                                        <br><span class="description"><?php echo esc_html($definition->getDescription()); ?></span>
                                    <?php endif; ?>
                                    <?php if ($definition->isBuiltin()) : ?>
                                        <br><span class="description"><?php esc_html_e('Type WordPress natif', 'lumina-api-v2'); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><code><?php echo esc_html($key); ?></code></td>
                                <td><code><?php echo esc_html($definition->getSlug()); ?></code></td>
                                <td><?php echo esc_html($apiLabel); ?></td>
                                <td>
                                    <label>
                                        <input
                                            type="checkbox"
                                            name="enabled[<?php echo esc_attr($key); ?>]"
                                            value="1"
                                            <?php checked($enabled); ?>
                                        />
                                        <?php esc_html_e('Activé', 'lumina-api-v2'); ?>
                                    </label>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <p class="submit">
                    <button type="submit" name="lumina_post_types_submit" class="button button-primary">
                        <?php esc_html_e('Enregistrer', 'lumina-api-v2'); ?>
                    </button>
                </p>
            </form>
        </div>
        <?php
    }

    private static function handleSave(): void
    {
        $registry = PostTypeRegistry::instance();
        $registry->discover();

        $posted = isset($_POST['enabled']) && is_array($_POST['enabled']) ? $_POST['enabled'] : [];
        $configuration = [];

        foreach ($registry->all() as $definition) {
            $key = sanitize_key($definition->getKey());
            $configuration[$key] = [
                'enabled' => isset($posted[$key]),
            ];
        }

        PostTypeRepository::save($configuration);

        wp_safe_redirect(add_query_arg('updated', '1', self::pageUrl()));
        exit;
    }

    private static function pageUrl(): string
    {
        return admin_url('admin.php?page=' . self::PAGE_SLUG);
    }
}
