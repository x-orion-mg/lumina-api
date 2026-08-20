# Création d’un Post Type

## Étapes

### 1. Créer le dossier

```
src/PostTypes/Definitions/Project/
├── Definition.php
├── Fields.php
└── Transformer.php   # optionnel
```

### 2. Definition.php

```php
<?php

namespace Lumina\ApiV2\PostTypes\Definitions\Project;

use Lumina\ApiV2\PostTypes\Contracts\PostTypeDefinitionProvider;
use Lumina\ApiV2\PostTypes\PostTypeDefinition;

class Definition implements PostTypeDefinitionProvider
{
    public static function create(): PostTypeDefinition
    {
        return PostTypeDefinition::fromArray([
            'key'             => 'project',
            'labels'          => [
                'name'          => 'Projets',
                'singular_name' => 'Projet',
            ],
            'slug'            => 'projects',
            'icon'            => 'dashicons-portfolio',
            'supports'        => ['title', 'editor', 'thumbnail', 'excerpt'],
            'public'          => true,
            'show_ui'         => true,
            'has_archive'     => true,
            'default_enabled' => false,
            'api'             => ['enabled' => true],
            'description'     => 'Projets réalisés.',
        ]);
    }
}
```

### 3. Fields.php (optionnel)

Voir [acf.md](acf.md).

### 4. Transformer.php (optionnel)

Si absent, le `DefaultPostTypeTransformer` est utilisé (format API standard).

### 5. Activer

1. Recharger WordPress (ou réactiver le plugin)
2. **Theme Settings → Lumina v2 → Post Types**
3. Cocher **Activé** pour le nouveau type
4. Enregistrer

### 6. Tester

```
GET /wp-json/lumina/v2/content-types
GET /wp-json/lumina/v2/fr/content/project
GET /wp-json/lumina/v2/fr/content/project/mon-projet
```

## Clés de configuration

| Clé | Description |
|-----|-------------|
| `key` | Identifiant WordPress du CPT (utilisé dans l’API) |
| `slug` | Slug de réécriture (`rewrite.slug`) |
| `labels` | Labels WordPress |
| `supports` | Supports WordPress (`title`, `editor`, `thumbnail`, etc.) |
| `taxonomies` | Taxonomies à associer |
| `icon` | Icône dashicons |
| `default_enabled` | Activé par défaut à la première découverte |
| `api.enabled` | Exposable par l’API Lumina |
| `builtin` | Type natif WP (`page`, `post`) — ne pas utiliser pour un CPT custom |
| `managed` | Si `false`, le plugin n’appelle pas `register_post_type()` |

## Exemple complet

Référence : `src/PostTypes/Definitions/Event/`
