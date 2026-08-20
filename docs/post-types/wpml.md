# WPML — Post Types

Le système de Post Types **réutilise** les services WPML existants. Aucune logique WPML spécifique n’est dupliquée dans chaque définition.

## Services utilisés

| Service | Rôle |
|---------|------|
| `LanguageService::runWithLanguage()` | Bascule WPML + langue ACF par requête API |
| `LanguageService::translatedObjectId()` | Résolution des traductions |
| `MultilingualSlug::getAllTranslationsSlugs()` | Slugs multilingues dans les réponses |

## URLs API

```
GET /wp-json/lumina/v2/fr/content/partner
GET /wp-json/lumina/v2/en/content/partner
GET /wp-json/lumina/v2/pt-br/content/partner
```

Le segment `{lang}` pilote :

1. `wpml_switch_language`
2. `acf/settings/current_language` pour les champs ACF du post
3. Résolution du contenu traduit par slug

## Slugs multilingues

Format inchangé :

```json
{
  "current": "fr",
  "fr": "legrand",
  "en": "legrand-en",
  "pt-br": "legrand-pt"
}
```

## Nouveaux CPT

Aucune configuration WPML supplémentaire dans `Definition.php`. Enregistrer le CPT via le plugin (ou le thème), puis configurer les traductions dans WPML comme pour tout autre type de contenu.

## Désactivation

Désactiver un CPT dans **Theme Settings → Lumina v2 → Post Types** :

- n’efface pas les traductions WPML ;
- retire le type de l’API et (si géré par le plugin) du menu WordPress.
