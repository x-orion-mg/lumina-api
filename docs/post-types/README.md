# Post Types — Lumina API v2

Architecture centralisée pour gérer les Custom Post Types (CPT) du plugin Lumina API v2.

## Vue d’ensemble

```
PostTypeDefinition
        ↓
PostTypeRegistry          ← source de vérité (découverte auto)
        ↓
 ┌──────┼───────────┐
 ↓      ↓           ↓
CPT     ACF         API REST
```

| Composant | Rôle |
|-----------|------|
| `PostTypeDefinition` | Encapsule la configuration d’un CPT |
| `PostTypeRegistry` | Centralise toutes les définitions découvertes |
| `PostTypeRepository` | Persiste l’activation/désactivation (`lumina_api_v2_post_types`) |
| `PostTypeRegistrar` | Appelle `register_post_type()` pour les CPT activés |
| `AcfGroupRegistrar` | Attache les champs ACF définis dans `Fields.php` |
| `PostTypeApiRegistry` | Détermine quels types sont exposés par l’API |
| `PostTypeTransformerResolver` | Résout le Transformer (custom ou défaut) |

## Administration

**Theme Settings → Lumina v2 → Post Types**

(URL : `/wp-admin/admin.php?page=lumina-v2-post-types`)

- Activer / désactiver chaque Post Type
- La désactivation **ne supprime aucune donnée**
- Capacité requise : `manage_options` (administrateur)
- Configuration stockée dans l’option `lumina_api_v2_post_types`

## Convention de développement

Pour ajouter un CPT, créer un dossier :

```
src/PostTypes/Definitions/{Name}/
├── Definition.php    # Configuration WordPress + API
├── Acf/
├    ├── Information.php
├    ├── Company.php
├    └── Contact.php        # Champs ACF (optionnel)
└── Transformer.php   # Format JSON API (optionnel)
```

Le `{Name}` du dossier doit correspondre au namespace PHP (`Partner` → `Definitions\Partner\Definition`).

Aucune modification de `Router.php`, `ContentController.php` ou `PostTypeRegistry.php` n’est nécessaire.

## Types WordPress natifs

`page` et `post` sont des définitions **builtin** :

- jamais enregistrés par le plugin ;
- activables/désactivables pour l’API uniquement.

## Rétrocompatibilité

Les CPT historiques (`partner`, `solution`, `testimony`, `actualite`, `type-beagile`, `type-be-inspired`) sont migrés dans `Definitions/`.

- Si le CPT existe déjà (ex. enregistré par le thème), le plugin **ne le ré-enregistre pas**
- L’API et le filtre `lumina_api_v2_exposed_post_types` restent compatibles

## Exemple de référence

Voir `Definitions/Event/` — CPT complet avec ACF et Transformer personnalisé.

## Documentation

- [Création d’un CPT](creation.md)
- [Champs ACF](acf.md)
- [API REST](api.md)
- [WPML](wpml.md)

## Filtres extensibles

| Filtre | Rôle |
|--------|------|
| `lumina_api_v2_post_type_definitions` | Modifier la liste des définitions |
| `lumina_api_v2_post_type_enabled` | Forcer l’état activé/désactivé |
| `lumina_api_v2_post_type_args` | Modifier les args `register_post_type()` |
| `lumina_api_v2_post_type_fields` | Modifier les champs ACF d’un CPT |
| `lumina_api_v2_post_type_transformer` | Changer la classe Transformer |
| `lumina_api_v2_exposed_post_types` | Filtre legacy (conservé) |
