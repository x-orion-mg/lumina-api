<?php

namespace Lumina\ApiV2\PostTypes;

class PostTypeDefinition
{
    /** @var array<string, mixed> */
    private array $config;

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(array $config)
    {
        if (empty($config['key']) || !is_string($config['key'])) {
            throw new \InvalidArgumentException('Post type definition requires a non-empty "key".');
        }

        $this->config = $config;
    }

    /**
     * @param array<string, mixed> $config
     */
    public static function fromArray(array $config): self
    {
        return new self($config);
    }

    public function getKey(): string
    {
        return (string) $this->config['key'];
    }

    /**
     * Slug de réécriture WordPress (rewrite slug).
     */
    public function getSlug(): string
    {
        if (!empty($this->config['slug']) && is_string($this->config['slug'])) {
            return $this->config['slug'];
        }

        return $this->getKey();
    }

    /**
     * @return array<string, string>
     */
    public function getLabels(): array
    {
        $labels = $this->config['labels'] ?? [];

        return is_array($labels) ? $labels : [];
    }

    public function getLabel(): string
    {
        $labels = $this->getLabels();

        if (!empty($labels['name']) && is_string($labels['name'])) {
            return $labels['name'];
        }

        return $this->getKey();
    }

    /**
     * @return array<int, string>
     */
    public function getSupports(): array
    {
        $supports = $this->config['supports'] ?? ['title', 'editor'];

        return is_array($supports) ? $supports : ['title', 'editor'];
    }

    /**
     * @return array<int, string>
     */
    public function getTaxonomies(): array
    {
        $taxonomies = $this->config['taxonomies'] ?? [];

        return is_array($taxonomies) ? $taxonomies : [];
    }

    public function getIcon(): string
    {
        return is_string($this->config['icon'] ?? null) ? $this->config['icon'] : 'dashicons-admin-post';
    }

    public function isPublic(): bool
    {
        return (bool) ($this->config['public'] ?? true);
    }

    public function showUi(): bool
    {
        return (bool) ($this->config['show_ui'] ?? true);
    }

    public function showInRest(): bool
    {
        return (bool) ($this->config['show_in_rest'] ?? false);
    }

    public function getMenuPosition(): ?int
    {
        return isset($this->config['menu_position']) ? (int) $this->config['menu_position'] : null;
    }

    public function isHierarchical(): bool
    {
        return (bool) ($this->config['hierarchical'] ?? false);
    }

    public function hasArchive(): bool
    {
        return (bool) ($this->config['has_archive'] ?? false);
    }

    /**
     * Types WordPress natifs (page, post) : jamais enregistrés par le plugin.
     */
    public function isBuiltin(): bool
    {
        return (bool) ($this->config['builtin'] ?? false);
    }

    /**
     * Si false, le plugin ne fait que l’exposition API (CPT géré ailleurs, ex. thème).
     */
    public function isManaged(): bool
    {
        if ($this->isBuiltin()) {
            return false;
        }

        return (bool) ($this->config['managed'] ?? true);
    }

    public function isApiEnabled(): bool
    {
        $api = $this->config['api'] ?? [];

        if (!is_array($api)) {
            return true;
        }

        return (bool) ($api['enabled'] ?? true);
    }

    public function isDefaultEnabled(): bool
    {
        return (bool) ($this->config['default_enabled'] ?? true);
    }

    public function getDescription(): string
    {
        return is_string($this->config['description'] ?? null) ? $this->config['description'] : '';
    }

    /**
     * @return array<string, mixed>
     */
    public function getDefinition(): array
    {
        return $this->config;
    }

    /**
     * Arguments passés à register_post_type().
     *
     * @return array<string, mixed>
     */
    public function getRegisterArgs(): array
    {
        $args = [
            'labels'       => $this->getLabels(),
            'public'       => $this->isPublic(),
            'show_ui'      => $this->showUi(),
            'show_in_rest' => $this->showInRest(),
            'supports'     => $this->getSupports(),
            'taxonomies'   => $this->getTaxonomies(),
            'hierarchical' => $this->isHierarchical(),
            'has_archive'  => $this->hasArchive(),
            'menu_icon'    => $this->getIcon(),
            'rewrite'      => [
                'slug' => $this->getSlug(),
            ],
        ];

        $menuPosition = $this->getMenuPosition();

        if ($menuPosition !== null) {
            $args['menu_position'] = $menuPosition;
        }

        return $args;
    }

    /**
     * Classes de groupes ACF associés au Post Type.
     *
     * @return array<int, string>
     */
    public function getAcfGroups(): array
    {
        $groups = $this->config['acf_groups'] ?? [];

        if (!is_array($groups)) {
            return [];
        }

        return array_values(
            array_filter(
                $groups,
                static function ($group): bool {
                    return is_string($group) && $group !== '';
                }
            )
        );
    }
}
