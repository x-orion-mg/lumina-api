<?php

namespace Lumina\ApiV2\PostTypes;

use Lumina\ApiV2\PostTypes\Contracts\PostTypeDefinitionProvider;

class PostTypeRegistry
{
    private static ?self $instance = null;

    /** @var array<string, PostTypeDefinition> */
    private array $definitions = [];

    /** @var array<string, string|null> */
    private array $transformerClasses = [];

    /** @var array<string, string|null> */
    private array $fieldsClasses = [];

    /** @var array<string, string> */
    private array $definitionPaths = [];

    private bool $discovered = false;

    public static function instance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function register(PostTypeDefinition $definition, ?string $definitionPath = null): void
    {
        $key = $definition->getKey();
        $this->definitions[$key] = $definition;

        if ($definitionPath !== null) {
            $this->definitionPaths[$key] = $definitionPath;
            $this->resolveCompanionClasses($key, $definitionPath);
        }
    }

    public function get(string $key): ?PostTypeDefinition
    {
        return $this->definitions[$key] ?? null;
    }

    public function has(string $key): bool
    {
        return isset($this->definitions[$key]);
    }

    /**
     * @return array<string, PostTypeDefinition>
     */
    public function all(): array
    {
        return $this->definitions;
    }

    /**
     * @return array<string, PostTypeDefinition>
     */
    public function enabled(): array
    {
        $enabled = [];

        foreach ($this->definitions as $key => $definition) {
            if ($this->isEnabled($key)) {
                $enabled[$key] = $definition;
            }
        }

        return $enabled;
    }

    public function isEnabled(string $key): bool
    {
        if (!$this->has($key)) {
            return false;
        }

        $definition = $this->get($key);
        $enabled = PostTypeRepository::isEnabled($key);

        /** @var bool $enabled */
        $enabled = apply_filters('lumina_api_v2_post_type_enabled', $enabled, $key, $definition);

        return (bool) $enabled;
    }

    public function discover(): void
    {
        if ($this->discovered) {
            return;
        }

        $definitionsDir = __DIR__ . '/Definitions';

        if (!is_dir($definitionsDir)) {
            $this->discovered = true;

            return;
        }

        foreach (glob($definitionsDir . '/*', GLOB_ONLYDIR) ?: [] as $dir) {
            $definitionFile = $dir . '/Definition.php';

            if (!file_exists($definitionFile)) {
                continue;
            }

            require_once $definitionFile;

            $folderName = basename($dir);
            $class = __NAMESPACE__ . '\\Definitions\\' . $folderName . '\\Definition';

            if (!class_exists($class)) {
                continue;
            }

            if (!is_subclass_of($class, PostTypeDefinitionProvider::class) && !method_exists($class, 'create')) {
                continue;
            }

            /** @var PostTypeDefinitionProvider $class */
            $definition = $class::create();
            $this->register($definition, $dir);
        }

        $this->definitions = apply_filters('lumina_api_v2_post_type_definitions', $this->definitions);

        PostTypeRepository::ensureDefaults($this);
        $this->discovered = true;
    }

    public function getTransformerClass(string $key): ?string
    {
        return $this->transformerClasses[$key] ?? null;
    }

    public function getFieldsClass(string $key): ?string
    {
        return $this->fieldsClasses[$key] ?? null;
    }

    public function getDefinitionPath(string $key): ?string
    {
        return $this->definitionPaths[$key] ?? null;
    }

    private function resolveCompanionClasses(string $key, string $definitionPath): void
    {
        $folderName = basename($definitionPath);
        $namespace = __NAMESPACE__ . '\\Definitions\\' . $folderName;

        $transformerClass = $namespace . '\\Transformer';
        $fieldsClass = $namespace . '\\Fields';

        if (file_exists($definitionPath . '/Transformer.php')) {
            require_once $definitionPath . '/Transformer.php';
            $this->transformerClasses[$key] = class_exists($transformerClass) ? $transformerClass : null;
        } else {
            $this->transformerClasses[$key] = null;
        }

        if (file_exists($definitionPath . '/Fields.php')) {
            require_once $definitionPath . '/Fields.php';
            $this->fieldsClasses[$key] = class_exists($fieldsClass) ? $fieldsClass : null;
        } else {
            $this->fieldsClasses[$key] = null;
        }
    }
}
