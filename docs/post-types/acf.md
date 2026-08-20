# Champs ACF par Post Type

Les champs ACF des CPT sont **séparés** des champs ACF des Blocks Gutenberg.

| Emplacement | Rôle |
|-------------|------|
| `src/Blocks/` | Champs des sections Gutenberg |
| `src/PostTypes/Definitions/{Name}/Fields.php` | Champs du CPT |

## Fields.php

```php
<?php

namespace Lumina\ApiV2\PostTypes\Definitions\Project;

class Fields
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public static function fields(): array
    {
        return [
            [
                'key'   => 'field_lumina_project_client',
                'label' => 'Client',
                'name'  => 'project_client',
                'type'  => 'text',
            ],
            [
                'key'           => 'field_lumina_project_cover',
                'label'         => 'Image de couverture',
                'name'          => 'project_cover',
                'type'          => 'image',
                'return_format' => 'array',
            ],
        ];
    }
}
```

## Enregistrement

`AcfGroupRegistrar` crée automatiquement un groupe ACF attaché au CPT :

```
location: post_type == {key}
```

## Helpers partagés

Les Transformers peuvent utiliser les Helpers existants :

- `Media::image()` — images
- `Button::parse()` — liens
- `Wysiwyg::parse()` — HTML
- `AcfFields::normalize()` — normalisation récursive ACF

## Filtre

```php
add_filter('lumina_api_v2_post_type_fields', function ($fields, $key, $definition) {
    if ($key === 'project') {
        $fields[] = [ /* champ additionnel */ ];
    }
    return $fields;
}, 10, 3);
```

## Désactivation

Lorsqu’un CPT est désactivé, les **données ACF existantes sont conservées** en base. Seul l’enregistrement du groupe local et du CPT par le plugin est suspendu.
