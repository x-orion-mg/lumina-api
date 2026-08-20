<?php


namespace Lumina\ApiV2\PostTypes\Acf;

use Lumina\ApiV2\PostTypes\PostTypeDefinition;
use Lumina\ApiV2\PostTypes\PostTypeRegistry;

class AcfRegistry
{
    private static ?self $instance = null;

    /**
     * @var array<string, array{
     *     class: class-string<AcfGroup>,
     *     post_types: array<string, bool>
     * }>
     */
    private array $groups = [];

    private bool $discovered = false;

    public static function instance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Découvre tous les groupes ACF des Post Types.
     */
    public function discover(): void
    {
        if ($this->discovered) {
            return;
        }

        $registry = PostTypeRegistry::instance();

        foreach ($registry->all() as $postTypeKey => $definition) {
            $definitionPath = $registry->getDefinitionPath($postTypeKey);

            if ($definitionPath !== null) {
                $this->discoverPostTypeGroups(
                    $postTypeKey,
                    $definitionPath
                );
            }

            foreach ($definition->getAcfGroups() as $groupClass) {
                if (!class_exists($groupClass)) {
                    continue;
                }

                if (!is_subclass_of($groupClass, AcfGroup::class)) {
                    continue;
                }

                $this->register(
                    $groupClass,
                    [$postTypeKey]
                );
            }
        }

        $this->discovered = true;
    }

    /**
     * Découvre les groupes dans :
     *
     * Definitions/{PostType}/Acf/
     */
    private function discoverPostTypeGroups(
        string $postTypeKey,
        string $definitionPath
    ): void
    {
        $acfDirectory = $definitionPath . '/Acf';

        if (!is_dir($acfDirectory)) {
            return;
        }

        foreach (glob($acfDirectory . '/*.php') ?: [] as $file) {
            $filename = basename($file, '.php');

            if ($filename === 'index') {
                continue;
            }

            require_once $file;

            $folderName = basename($definitionPath);

            $class = 'Lumina\\ApiV2\\PostTypes\\Definitions\\'
                . $folderName
                . '\\Acf\\'
                . $filename;

            if (!class_exists($class)) {
                continue;
            }

            if (!is_subclass_of($class, AcfGroup::class)) {
                continue;
            }

            $this->register(
                $class,
                [$postTypeKey]
            );
        }
    }

    /**
     * Découvre les groupes partagés.
     */
    private function discoverSharedGroups(): void
    {
        $sharedDirectory = __DIR__ . '/Shared';

        if (!is_dir($sharedDirectory)) {
            return;
        }

        foreach (glob($sharedDirectory . '/*.php') ?: [] as $file) {
            $filename = basename($file, '.php');

            require_once $file;

            $class = __NAMESPACE__ . '\\Shared\\' . $filename;

            if (!class_exists($class)) {
                continue;
            }

            if (!is_subclass_of($class, AcfGroup::class)) {
                continue;
            }

            /*
             * Les groupes Shared ne sont pas attachés automatiquement
             * à tous les Post Types.
             *
             * Ils seront attachés par Definition::acfGroups().
             */
        }
    }

    /**
     * Enregistre un groupe ACF.
     *
     * @param class-string<AcfGroup> $class
     * @param array<int, string> $postTypes
     */
    public function register(
        string $class,
        array  $postTypes = []
    ): void
    {
        $key = $class::key();

        if ($key === '') {
            return;
        }

        if (!isset($this->groups[$key])) {
            $this->groups[$key] = [
                'class' => $class,
                'post_types' => [],
            ];
        }

        foreach ($postTypes as $postType) {
            if ($postType === '') {
                continue;
            }

            $this->groups[$key]['post_types'][$postType] = true;
        }
    }

    /**
     * Retourne tous les groupes.
     *
     * @return array<string, array{
     *     class: class-string<AcfGroup>,
     *     post_types: array<string, bool>
     * }>
     */
    public function all(): array
    {
        return $this->groups;
    }

    /**
     * Retourne les groupes actifs.
     *
     * @return array<string, array{
     *     class: class-string<AcfGroup>,
     *     post_types: array<string, bool>
     * }>
     */
    public function active(): array
    {
        $this->discover();

        $registry = PostTypeRegistry::instance();

        $active = [];

        foreach ($this->groups as $key => $group) {
            $activePostTypes = [];

            foreach ($group['post_types'] as $postType => $_) {
                $definition = $registry->get($postType);

                if (!$definition) {
                    continue;
                }

                /*
                 * Post Type géré par un autre système
                 * (WooCommerce, thème, etc.).
                 *
                 * Il suffit qu'il existe réellement.
                 */
                if (
                    !$definition->isManaged()
                    && post_type_exists($postType)
                ) {
                    $activePostTypes[] = $postType;
                    continue;
                }

                if ($registry->isEnabled($postType)) {
                    $activePostTypes[] = $postType;
                }
            }

            if ($activePostTypes === []) {
                continue;
            }

            $active[$key] = [
                'class' => $group['class'],
                'post_types' => array_fill_keys($activePostTypes, true),
            ];
        }

        return $active;
    }

    /**
     * Construit les locations ACF automatiques.
     *
     * @param array<int, string> $postTypes
     *
     * @return array<int, array<int, array<string, string>>>
     */
    public function buildLocation(array $postTypes): array
    {
        $location = [];

        foreach ($postTypes as $postType) {
            $location[] = [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => $postType,
                ],
            ];
        }

        return $location;
    }

    /**
     * Retourne la configuration finale d'un groupe.
     *
     * @param array{
     *     class: class-string<AcfGroup>,
     *     post_types: array<string, bool>
     * } $group
     *
     * @return array<string, mixed>
     */
    public function buildGroupConfig(array $group): array
    {
        $class = $group['class'];

        $config = $class::config();

        $config['key'] = $class::key();
        $config['title'] = $class::title();
        $config['fields'] = $class::fields();

        $explicitLocation = $class::location();

        if ($explicitLocation !== null) {
            $config['location'] = $explicitLocation;
        } else {
            $config['location'] = $this->buildLocation(
                array_keys($group['post_types'])
            );
        }

        return $config;
    }
}