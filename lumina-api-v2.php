<?php

/**
 * Plugin Name: Lumina API v2
 * Description: Plugin de gestation API V2 de Lumina.
 * Author: Mahery
 * Version: 1.1.0
 */

const LUMINA_API_V2_PATH = __DIR__;
define('LUMINA_API_V2_URL', plugin_dir_url(__FILE__));

require_once __DIR__ . '/vendor/autoload.php';

use Lumina\ApiV2\Core\Plugin;

add_action('plugins_loaded', [Plugin::class, 'boot']);