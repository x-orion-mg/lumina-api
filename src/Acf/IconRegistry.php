<?php

namespace Lumina\ApiV2\Acf;

class IconRegistry
{
    /**
     * Catalogue des icônes Lumina.
     *
     * Pour ajouter une icône :
     * 1. Déposer le fichier SVG dans assets/icons/{slug}.svg
     * 2. Ajouter une entrée ci-dessous (ou appeler register() depuis un hook).
     *
     * @var array<string, array{label: string, file?: string}>
     */
    private static array $icons = [
        'shield' => [
            'label' => 'Bouclier',
            'file'  => 'shield.svg',
        ],
        'check-circle' => [
            'label' => 'Validation',
            'file'  => 'check-circle.svg',
        ],
        'alert' => [
            'label' => 'Alerte',
            'file'  => 'alert.svg',
        ],
        'users' => [
            'label' => 'Utilisateurs',
            'file'  => 'users.svg',
        ],
        'document' => [
            'label' => 'Document',
            'file'  => 'document.svg',
        ],
        'lucide-building2' => [
            'label' => 'Lucide Building',
            'file'  => 'lucide-building2.svg',
        ],
        'lucide-landmark' => [
            'label' => 'Lucide Landmark',
            'file'  => 'lucide-landmark.svg',
        ],
        'lucide-graduation-cap' => [
            'label' => 'Lucide graduation cap',
            'file'  => 'lucide-graduation-cap.svg',
        ],
        'lucide-scale' => [
            'label' => 'Lucide scale',
            'file'  => 'lucide-scale.svg',
        ],
        'lucide-gift' => [
            'label' => 'Lucide gift',
            'file'  => 'lucide-gift.svg',
        ],
        'lucide-shield' => [
            'label' => 'Lucide shield',
            'file'  => 'lucide-shield.svg',
        ],
        'lucide-heart' => [
            'label' => 'Lucide heart',
            'file'  => 'lucide-heart.svg',
        ],
        'lucide-users' => [
            'label' => 'Lucide users',
            'file'  => 'lucide-users.svg',
        ],
        'lucide-pill' => [
            'label' => 'Lucide pill',
            'file'  => 'lucide-pill.svg',
        ],
        'lucide-lock' => [
            'label' => 'Lucide lock',
            'file'  => 'lucide-lock.svg',
        ],
        'lucide-mic' => [
            'label' => 'Lucide mic',
            'file'  => 'lucide-mic.svg',
        ],
        'lucide-earth' => [
            'label' => 'Lucide earth',
            'file'  => 'lucide-earth.svg',
        ],
        'lucide-shield-alert' => [
            'label' => 'Lucide shield alert',
            'file'  => 'lucide-shield-alert.svg',
        ],
        'lucide-users-round' => [
            'label' => 'Lucide users round',
            'file'  => 'lucide-users-round.svg',
        ],
        'lucide-heart-handshake' => [
            'label' => 'Lucide heart handshake',
            'file'  => 'lucide-heart-handshake.svg',
        ],
        'lucide-trending-up' => [
            'label' => 'Lucide trending up',
            'file'  => 'lucide-trending-up.svg',
        ],
        'lucide-zap' => [
            'label' => 'Lucide zap',
            'file'  => 'lucide-zap.svg',
        ],
        'lucide-shield-check' => [
            'label' => 'Lucide shield check',
            'file'  => 'lucide-shield-check.svg',
        ],
        'lucide-sparkles' => [
            'label' => 'Lucide sparkles',
            'file'  => 'lucide-sparkles.svg',
        ],
        'lucide-file-text' => [
            'label' => 'Lucide file text',
            'file'  => 'lucide-file-text.svg',
        ],
        'lucide-settings' => [
            'label' => 'Lucide settings',
            'file'  => 'lucide-settings.svg',
        ],
        'lucide-check' => [
            'label' => 'Lucide check',
            'file'  => 'lucide-check.svg',
        ],
        'lucide-headphones' => [
            'label' => 'Lucide headphones',
            'file'  => 'lucide-headphones.svg',
        ],
        'lucide-handshake' => [
            'label' => 'Lucide handshake',
            'file'  => 'lucide-handshake.svg',
        ],
        'lucide-book-open' => [
            'label' => 'Lucide book open',
            'file'  => 'lucide-book-open.svg',
        ],
        'lucide-quote' => [
            'label' => 'Lucide quote',
            'file'  => 'lucide-quote.svg',
        ],
        'lucide-leaf' => [
            'label' => 'Lucide leaf',
            'file'  => 'lucide-leaf.svg',
        ],
        'lucide-coins' => [
            'label' => 'Lucide coins',
            'file'  => 'lucide-coins.svg',
        ],
        'lucide-package' => [
            'label' => 'Lucide package',
            'file'  => 'lucide-package.svg',
        ],
        'lucide-globe' => [
            'label' => 'Lucide globe',
            'file'  => 'lucide-globe.svg',
        ],
        'lucide-settings2' => [
            'label' => 'Lucide settings 2',
            'file'  => 'lucide-settings2.svg',
        ],
        'lucide-eye' => [
            'label' => 'Lucide eye',
            'file'  => 'lucide-eye.svg',
        ],
        'lucide-mail' => [
            'label' => 'Lucide mail',
            'file'  => 'lucide-mail.svg',
        ],
        'lucide-circle-help' => [
            'label' => 'Lucide circle help',
            'file'  => 'lucide-circle-help.svg',
        ],
        'lucide-file-check2' => [
            'label' => 'Lucide file check 2',
            'file'  => 'lucide-file-check2.svg',
        ],
        'lucide-life-buoy' => [
            'label' => 'Lucide life buoy',
            'file'  => 'lucide-life-buoy.svg',
        ],
        'lucide-languages' => [
            'label' => 'Lucide languages',
            'file'  => 'lucide-languages.svg',
        ],
        'lucide-compass' => [
            'label' => 'Lucide compass',
            'file'  => 'lucide-compass.svg',
        ],
        'lucide-scroll-text' => [
            'label' => 'Lucide scroll text',
            'file'  => 'lucide-scroll-text.svg',
        ],
        'lucide-layers' => [
            'label' => 'Lucide layers',
            'file'  => 'lucide-layers.svg',
        ],
    ];

    /**
     * Enregistre ou remplace une icône (ex. depuis un autre plugin / thème).
     */
    public static function register(string $slug, string $label, ?string $file = null): void
    {
        self::$icons[$slug] = [
            'label' => $label,
            'file'  => $file ?? $slug . '.svg',
        ];
    }

    /**
     * @return array<string, array{label: string, file?: string}>
     */
    private static function icons(): array
    {
        return apply_filters('lumina_api_v2_icons', self::$icons);
    }

    /**
     * @return array<string, array{label: string, file: string, url: string}>
     */
    public static function all(): array
    {
        $out = [];

        foreach (self::icons() as $slug => $meta) {
            $resolved = self::resolve($slug);

            if ($resolved !== null) {
                $out[$slug] = $resolved;
            }
        }

        return $out;
    }

    /**
     * Choix pour le champ ACF select (value => label).
     *
     * @return array<string, string>
     */
    public static function choices(): array
    {
        $choices = [];

        foreach (self::icons() as $slug => $meta) {
            $choices[$slug] = $meta['label'];
        }

        return $choices;
    }

    /**
     * Données pour l'admin JS (aperçu Select2).
     *
     * @return array<string, array{label: string, url: string}>
     */
    public static function forAdmin(): array
    {
        $out = [];

        foreach (self::all() as $slug => $icon) {
            $out[$slug] = [
                'label' => $icon['label'],
                'url'   => $icon['url'],
            ];
        }

        return $out;
    }

  /**
     * Résout une icône pour l'API (slug, label, url).
     */
    public static function resolve(?string $slug): ?array
    {
        if ($slug === null || $slug === '') {
            return null;
        }

        $icons = self::icons();

        if (!isset($icons[$slug])) {
            return null;
        }

        $meta = $icons[$slug];
        $file = $meta['file'] ?? $slug . '.svg';
        $url = self::assetUrl($file);

        if ($url === null) {
            return null;
        }

        return [
            'slug'  => $slug,
            'label' => $meta['label'],
            'file'  => $file,
            'url'   => $url,
        ];
    }

    private static function assetUrl(string $file): ?string
    {
        $path = LUMINA_API_V2_PATH . '/assets/icons/' . ltrim($file, '/');

        if (!is_readable($path)) {
            return null;
        }

        return LUMINA_API_V2_URL . 'assets/icons/' . ltrim($file, '/');
    }
}
