<?php

namespace Lumina\ApiV2\WooCommerce;

class WooCommerceServiceProvider
{
    public function boot(): void
    {
        $this->loadDirectory(__DIR__ . '/Hooks', 'Lumina\\ApiV2\\WooCommerce\\Hooks');
        $this->loadDirectory(__DIR__ . '/Admin', 'Lumina\\ApiV2\\WooCommerce\\Admin');
    }

    protected function loadDirectory(string $directory, string $namespace): void
    {
        if (! is_dir($directory)) {
            return;
        }

        foreach (glob($directory . '/*.php') as $file) {
            $class = $namespace . '\\' . basename($file, '.php');

            if (! class_exists($class)) {
                continue;
            }

            if (! method_exists($class, 'register')) {
                continue;
            }

            $class::register();
        }
    }
}