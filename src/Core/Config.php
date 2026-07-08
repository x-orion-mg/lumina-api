<?php

namespace Lumina\ApiV2\Core;

class Config
{
    // 🔥 Namespace API WordPress
    public const API_NAMESPACE = 'lumina/v2';

    // 🔥 Version API séparée (utile pour évolution)
    public const API_VERSION = 'v2';

    // 🔥 Base route (optionnel)
    public const API_BASE = 'lumina';

    /** Slug page options ACF du plugin (sous Theme Settings si disponible). */
    public const OPTIONS_SLUG = 'lumina-v2-settings';

    /** Slug options thème legacy (lumina). */
    public const THEME_OPTIONS_SLUG = 'theme-general-settings';
}