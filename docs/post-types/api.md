# API REST — Post Types

## Routes (inchangées)

```
GET /wp-json/lumina/v2/content-types
GET /wp-json/lumina/v2/{lang}/content/{post_type}
GET /wp-json/lumina/v2/{lang}/content/{post_type}/{slug}
```

Le `{post_type}` correspond à la **clé** WordPress (`key` dans la définition), pas au slug de réécriture.

Exemple Event :

```
GET /wp-json/lumina/v2/fr/content/event
GET /wp-json/lumina/v2/fr/content/event/conference-2026
```

## content-types

Retourne uniquement les Post Types **activés** et **API-enabled** :

```json
{
  "success": true,
  "data": {
    "items": [
      {
        "key": "partner",
        "slug": "partner",
        "rewrite_slug": "partner",
        "label": "Partenaires",
        "api_enabled": true,
        "hierarchical": false,
        "rest_base": "partner",
        "has_archive": false,
        "builtin": false,
        "managed": true
      }
    ],
    "total": 1
  }
}
```

Les champs `slug`, `hierarchical`, `rest_base`, `has_archive` sont conservés pour la rétrocompatibilité frontend.

## Format détail (défaut)

Identique au format existant :

```json
{
  "id": 42,
  "post_type": "event",
  "title": "Conférence 2026",
  "slug": {
    "current": "fr",
    "fr": "conference-2026",
    "en": "conference-2026"
  },
  "lang": "fr",
  "excerpt": "...",
  "featured_image": {},
  "date": "2026-03-01T10:00:00+01:00",
  "modified": "2026-03-01T10:00:00+01:00",
  "content_mode": "acf",
  "blocks": [],
  "content": "",
  "acf": {},
  "meta_data": {}
}
```

## Transformer personnalisé

Event ajoute un bloc `event` structuré en plus du format standard :

```json
{
  "event": {
    "date": "2026-06-15",
    "location": "Paris",
    "description": "...",
    "registration_url": { "url": "...", "label": "..." }
  }
}
```

## Sécurité

Routes publiques (`permission_callback => __return_true`). JWT hors scope.

## Filtre legacy

`lumina_api_v2_exposed_post_types` reste supporté pour ajouter ou retirer des types exposés.

```php
add_filter('lumina_api_v2_exposed_post_types', function ($types) {
    $types['custom-type'] = ['label' => 'Mon type'];
    return $types;
});
```
