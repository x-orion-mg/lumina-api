# Lumina API v2

Plugin WordPress **headless** : exposition REST JSON propre pour pages Gutenberg (ACF), contenus (CPT), layout global (header / footer / others), icônes et SEO (Yoast). Intégration WooCommerce optionnelle (emails headless).

---

## Prérequis

- WordPress + **ACF Pro** (blocks, options, repeaters)
- Composer (`composer install` dans le plugin)
- Recommandé : **Yoast SEO**, **WPML** (multilingue), CPT `contact-form` (thème Lumina) pour les formulaires HubSpot
- Optionnel : **WooCommerce** (emails personnalisés, délai d’annulation des commandes impayées)

---

## Installation

1. Copier dans `wp-content/plugins/lumina-api-v2`
2. Activer le plugin
3. `composer install` si besoin

Constantes définies à l’activation :

- `LUMINA_API_V2_PATH`
- `LUMINA_API_V2_URL`

---

## API REST

Base : `/wp-json/lumina/v2/`

Toutes les routes sont **publiques** (`permission_callback => __return_true`). Aucune authentification n’est requise pour l’instant (JWT prévu en roadmap).

Réponse standard :

```json
{
  "success": true,
  "data": { }
}
```

Exemples complets : `examples/rest-api.http`

### Pages

```
GET /wp-json/lumina/v2/{lang}/page/{slug}
```

Exemples :

- `/fr/page/home-v2`
- `/en/page/about`
- `/pt-br/page/contact` (codes langue avec tiret supportés)

**Contenu `data` :**

| Champ | Description |
|--------|-------------|
| `id`, `title`, `lang` | Page WordPress |
| `slug` | Slugs multilingues (voir ci-dessous) |
| `acf` | Champs ACF page (brut) |
| `blocks` | Sections Gutenberg transformées (`type` + `data`) |
| `meta_data` | SEO Yoast (titre, OG, schema, breadcrumbs…) |

### Contenus (CPT & posts)

```
GET /wp-json/lumina/v2/content-types
GET /wp-json/lumina/v2/{lang}/content/{post_type}
GET /wp-json/lumina/v2/{lang}/content/{post_type}/{slug}
```

**Réponse `content-types`** — chaque item contient :

| Champ | Description |
|-------|-------------|
| `key` / `slug` | Identifiant WordPress du type (utilisé dans l’URL API) |
| `rewrite_slug` | Slug de réécriture (`rewrite.slug`) |
| `label` | Libellé affiché |
| `api_enabled` | Exposition API activée dans la définition |
| `hierarchical`, `rest_base`, `has_archive` | Métadonnées WordPress (rétrocompat.) |
| `builtin` | Type natif (`page`, `post`) |
| `managed` | Enregistré par le plugin via `register_post_type()` |

**Types exposés** — alimentés par `PostTypeRegistry` (CPT activés dans l’admin). Filtrables via `lumina_api_v2_exposed_post_types`.

| `post_type` | Label | Notes |
|-------------|-------|-------|
| `page` | Pages | Type WordPress natif |
| `post` | Articles | Type WordPress natif |
| `partner` | Partenaires | |
| `testimony` | Témoignages | |
| `solution` | Solutions | |
| `type-beagile` | Types Be Agile | |
| `type-be-inspired` | Types Be Inspired | |
| `actualite` | Actualités | |
| `event` | Événements | Exemple — activable dans l’admin |

**Liste** — paramètres de requête :

| Param | Défaut | Description |
|-------|--------|-------------|
| `page` | `1` | Page courante |
| `per_page` | `20` | Résultats par page (max 100) |
| `search` | — | Recherche textuelle WordPress |

Réponse liste : `items` (résumé), `pagination` (`page`, `per_page`, `total`, `total_pages`), `filters`.

**Résumé (`items`)** : `id`, `post_type`, `title`, `slug`, `lang`, `excerpt`, `featured_image`, `date`, `modified`.

**Détail** : champs du résumé + `content_mode`, `blocks`, `content` (WYSIWYG), `acf`, `meta_data`.

**`content_mode`** : indique la forme du contenu — `blocks`, `wysiwyg`, `acf`, `mixed` ou `empty`.

### Layout global

```
GET /wp-json/lumina/v2/{lang}/layout/header
GET /wp-json/lumina/v2/{lang}/layout/footer
GET /wp-json/lumina/v2/{lang}/layout/others
```

Configurés dans **Theme Settings → Lumina v2 → Layout** (options ACF du plugin).

**Layout others** — navigation documents légaux (placeholder recherche, liste de documents, bloc d’aide avec CTA HubSpot). Paramètre optionnel `?type=legal_documents_navigation` pour ne retourner que cette section.

### Icônes

```
GET /wp-json/lumina/v2/icons
GET /wp-json/lumina/v2/icons?search=shield
GET /wp-json/lumina/v2/icons/{slug}
```

Catalogue SVG Lumina (~45 icônes dans `assets/icons/`). Utilisé par le champ ACF `icon_lumina` et exposé en API pour le frontend.

---

## Multilingue (WPML)

Le segment `{lang}` de l’URL :

1. Bascule WPML (`wpml_switch_language`)
2. Applique `acf/settings/current_language` pour les **options ACF**
3. Résout les pages traduites (`wpml_object_id`) dans `PageService` et `PostContentService`

Langue par défaut : `wpml_default_language` ou `fr`.

### Slugs multilingues

Sur les pages et contenus, le champ `slug` est un objet (et non une simple chaîne) :

```json
{
  "current": "fr",
  "fr": "mentions-legales",
  "en": "legal-notice",
  "pt-br": "aviso-legal"
}
```

Clé `current` = code langue de la requête ; les autres clés = slug dans chaque langue WPML active.

---

## Architecture

```
lumina-api-v2/
├── lumina-api-v2.php
├── assets/
│   ├── icons/          # SVG icônes (icon_lumina)
│   └── admin/          # CSS/JS aperçu icônes ACF
├── docs/
│   ├── guide-utilisateur/  # Guide éditeur (un .md par block)
│   └── post-types/         # Documentation Post Types
├── examples/
│   └── rest-api.http   # Exemples requêtes REST
├── src/
│   ├── Core/           # Plugin, Router, Config
│   ├── Controllers/    # Page, Layout, Content, Icon, Others
│   ├── Services/       # Page, Header, Footer, Meta, HubSpotForm, Language, PostContent…
│   ├── Transformers/   # Page, Blocks, Header, Footer, PostContent, Others
│   ├── Helpers/        # Response, Media, Button, Cta, Icon, Wysiwyg, MultilingualSlug…
│   ├── Acf/            # IconRegistry, IconField, ButtonFields
│   ├── Options/        # Layout, Settings (ACF) + PostTypes (admin WP)
│   │   ├── Layout/     # Header, Footer, Others
│   │   ├── Settings/   # API, WooCommerce
│   │   └── PostTypes/  # Page admin Post Types
│   ├── PostTypes/      # Registry, Definitions, Registration, ACF, API, Admin
│   ├── WooCommerce/    # Emails headless, annulation commandes impayées
│   └── Blocks/         # Un dossier par section Gutenberg
└── templates/
    └── woocommerce/emails/  # Surcharges emails WC
```

Flux : **WordPress → Services / Transformers → JSON → Frontend (Next.js, etc.)**

---

## Post Types dynamiques

Architecture centralisée dans `src/PostTypes/` pour gérer les CPT de façon extensible.

```
PostTypeDefinition → PostTypeRegistry → CPT + ACF + API REST
```

### Administration

**Theme Settings → Lumina v2 → Post Types**

(URL directe : `/wp-admin/admin.php?page=lumina-v2-post-types`)

Page WordPress native (formulaire custom, pas une page ACF). Capacité requise : **`manage_options`** (administrateur).

Activer / désactiver chaque Post Type. La configuration est persistée dans l’option WordPress `lumina_api_v2_post_types`. La désactivation ne supprime aucune donnée WordPress.

### Ajouter un CPT

Créer un dossier (découverte automatique) :

```
src/PostTypes/Definitions/MyType/
├── Definition.php    # Configuration WordPress + API
├── Fields.php        # Champs ACF (optionnel)
└── Transformer.php   # Format JSON API (optionnel)
```

Puis activer dans l’admin. Aucune modification de `Router.php` ou `ContentController.php` requise.

Exemple de référence : `Definitions/Event/`

Documentation complète : [`docs/post-types/`](docs/post-types/README.md)

### Filtres Post Types

| Filtre | Rôle |
|--------|------|
| `lumina_api_v2_post_type_definitions` | Modifier les définitions |
| `lumina_api_v2_post_type_enabled` | Forcer activé/désactivé |
| `lumina_api_v2_post_type_should_register` | Autoriser ou bloquer l’appel à `register_post_type()` |
| `lumina_api_v2_post_type_args` | Args `register_post_type()` |
| `lumina_api_v2_post_type_fields` | Champs ACF d’un CPT |
| `lumina_api_v2_post_type_transformer` | Classe Transformer |

---

## Blocks Gutenberg (ACF)

Chaque section dans `src/Blocks/{NomBlock}/` :

| Fichier | Rôle |
|---------|------|
| `config.php` | `acf_register_block_type` (`name` → `acf/be-…`) |
| `fields.php` | Groupe ACF local |
| `render.php` | Aperçu éditeur |
| `Transformer.php` | Sortie API (`BlockResponse::make`) |
| `preview.png` / `.svg` | Optionnel |

**Enregistrement auto** : `Blocks\Loader` + `Blocks\TransformerRegistry` (découverte par dossier, namespace PascalCase). Catégorie éditeur : **Lumina**.

Guide éditeur détaillé : `docs/guide-utilisateur/` (marketing / contenus).

### Blocks disponibles (v2)

| Block ACF | Type API |
|-----------|----------|
| `be-hero` | `hero` |
| `be-hero-main` | `hero_main` |
| `be-hero-solutions` | `hero_solutions` |
| `be-rebranding-story-hero` | `rebranding_story_hero` |
| `be-about-stats` | `about_stats` |
| `be-partners` | `partners` |
| `be-why-choose` | `be-different` |
| `be-why-choose-solutions` | `why_choose_solutions` |
| `be-human-first` | `be-HumanFirst` |
| `be-features-tabs` | `be-smart` |
| `be-key-features` | `key_features` |
| `be-flexible-platform` | `be-agile` |
| `be-compliance-targets` | `be-confident` |
| `be-values` | `be-inspired` |
| `be-proof-section` | `proof_section` |
| `be-testimonials` | `be-impactful` |
| `be-team-testimonials` | `team_testimonials` |
| `be-cta-banner` | `cta_banner` |
| `be-cta-solutions` | `cta_solutions` |
| `be-cta-community` | `cta_community` |
| `be-cta-career` | `cta_career` |
| `demo-request` | `demo_request` |
| `be-contact-form-section` | `contact_form_section` |
| `be-faq-section` | `faq_section` |
| `be-rebranding-timeline` | `rebranding_timeline` |
| `be-privacy-policy` | `privacy_policy` |
| `be-legal-mentions` | `legal_mentions` |
| `be-legal-documents-navigation` | `legal_documents_navigation` |

Format block API :

```json
{
  "type": "hero",
  "data": {
    "title": "...",
    "image": { "id": 1, "url": "...", "alt": "", "width": 0, "height": 0 }
  }
}
```

Blocks sans transformer dédié : fallback via `AcfBlockData` (données ACF brutes).

---

## Helpers

### `AcfBlockData::extract($block)`

Extrait les champs ACF d’un block Gutenberg (sans clés `_field`).

### `AcfRepeater::parse` / `parseFromBlockData` / `parseFromBlockDataPrefixed`

Gère les repeaters en **tableau** ou format **aplati** (`repeater_0_champ`) dans les attributs de block, y compris repeaters imbriqués.

### `Media::image($value)`

Image ACF → `{ id, url, alt, width, height }`.

### `Button::parse($value)`

Lien ACF, URL, détection HubSpot URL, slug page interne.

### `Icon::parse($slug)` / champ `icon_lumina`

Catalogue dans `Acf\IconRegistry` + aperçu admin (`assets/icons/`).

### `Cta::parse($data, $options)` — boutons & HubSpot

Remplace l’ancien `CGutenburg::lumina_HubSpot()` du thème. À appeler **uniquement dans le Transformer** du block concerné.

**Lien classique** (champ ACF Link) :

```php
use Lumina\ApiV2\Helpers\Cta;

'primary_button' => Cta::parse($data, [
    'link_field' => 'primary_button',
    'mode_field' => 'primary_is_contact_form', // si absent → lien seul
]),
```

**Mode formulaire HubSpot** (comme l’ancien thème) :

- `is_contact_form` = `contact_form` (select) ou `true` (true/false)
- `label_button` = libellé
- `contact_form` = relationship → CPT `contact-form`

Réponse type :

```json
{
  "type": "hubspot_form",
  "label": "Demander une démo",
  "hubspot": true,
  "contact_form": {
    "id": 42,
    "title": "Demo FR",
    "slug": "demo-fr",
    "hubspot": {
      "type": "form",
      "portalId": "145051139",
      "formId": "abc-123"
    }
  },
  "is_contact_form": true,
  "hubSpot": { "type": "form", "portalId": "...", "formId": "..." },
  "title": "Demander une démo"
}
```

Les clés `is_contact_form`, `hubSpot`, `title` restent pour compatibilité avec l’ancienne API front.

### `Wysiwyg::parse($html)`

Pour les champs ACF **WYSIWYG** : parcourt les `<a href="…">`, détecte les URLs **internes** (même domaine ou chemin relatif), applique le filtre thème `lumina_api_link`, puis remplace le `href` par le **slug** de la page (`/mentions-legales`, etc.).

```php
use Lumina\ApiV2\Helpers\Wysiwyg;

'conditions' => Wysiwyg::parse($data['description_conditions'] ?? ''),
```

Filtres :

- `lumina_api_v2_wysiwyg_internal_url` — ajuster le chemin final (`$path`, `$postId`, `$originalUrl`)
- `lumina_api_v2_wysiwyg_home_slug` — slug de la page d’accueil (défaut : `''` → `/`)
- `lumina_api_v2_wysiwyg` — HTML complet après traitement

### `HubSpotFormService`

Pour un block qui expose **directement** un formulaire (ex. Demo Request) :

```php
use Lumina\ApiV2\Services\HubSpotFormService;

'form' => HubSpotFormService::resolveEmbedded($data['form'] ?? null, [
    'title'       => $data['form_title'] ?? '',
    'description' => $data['form_description'] ?? '',
    'conditions'  => $data['description_conditions'] ?? '',
]),
```

Utilise `CContactForm::getById()` du thème si disponible, sinon parse le shortcode ACF `short_code_hubspot`.

### `Acf\ButtonFields::group($prefix)`

Champs ACF prêts à l’emploi (mode lien / HubSpot) pour vos `fields.php`.

---

## Options ACF (admin)

**Admin :** Theme Settings → **Lumina v2** (sous-menu du thème Lumina, ou menu autonome sinon).

| Emplacement | Contenu | Technologie |
|-------------|---------|-------------|
| **Lumina v2 → Layout** | Header, Footer, Others | ACF Options |
| **Lumina v2 → Réglages** | URLs frontend, WooCommerce | ACF Options |
| **Lumina v2 → Post Types** | Activation/désactivation des CPT | Page WP custom (`manage_options`) |

### Layout

Sous-page **Layout** — champs traduits par WPML :

**Header**

- Logo, téléphone, CTA, sélecteur de langue
- Navigation : lien simple ou **mega menu** (titre, description, liens, cartes avec `icon_lumina`)

**Footer**

- Logo + description
- Colonnes : liens ou **certifications** (badges)
- Copyright, liens légaux, réseaux sociaux

**Others**

- Navigation documents légaux : placeholder recherche, titre section, dernière mise à jour
- Liste de documents (liens)
- Bloc « Besoin d’aide » (titre, description, bouton lien ou HubSpot)

### Réglages

Sous-page **Réglages** :

| Champ | Usage |
|-------|-------|
| `frontend_url` | URL du frontend headless (référence admin ; non consommée en PHP pour l’instant) |
| `login_page_url` | Lien connexion frontend → email WooCommerce « Nouveau compte » |
| `password_reset_url` | Lien réinitialisation mot de passe → email WooCommerce |
| `wc_cancel_unpaid_orders_interval` | Délai annulation commandes impayées : `hour` (1 h), `day` (24 h), `week` (7 j) |

---

## WooCommerce

Chargé automatiquement si WooCommerce est actif (`WooCommerceServiceProvider`).

| Fonctionnalité | Description |
|----------------|-------------|
| **Emails headless** | Surcharge `customer-new-account` et `customer-reset-password` avec les URLs frontend (`login_page_url`, `password_reset_url`) |
| **Annulation commandes impayées** | Filtre `woocommerce_cancel_unpaid_orders_interval` selon l’option ACF |

Templates : `templates/woocommerce/emails/`

Pas d’endpoint REST WooCommerce dans ce plugin — l’intégration porte sur les emails et le cron natif WC.

---

## SEO

`meta_data` sur chaque page et contenu via **Yoast** (`MetaService`), avec repli sur `CMetaData` du thème si présent.

---

## Extensibilité (filtres)

| Filtre | Rôle |
|--------|------|
| `lumina_api_v2_exposed_post_types` | Ajouter / retirer des CPT exposés par l’API (legacy, conservé) |
| `lumina_api_v2_post_type_definitions` | Modifier les définitions Post Types |
| `lumina_api_v2_post_type_enabled` | Forcer l’état activé/désactivé d’un Post Type |
| `lumina_api_v2_post_type_should_register` | Autoriser ou bloquer l’appel à `register_post_type()` |
| `lumina_api_v2_post_type_args` | Modifier les args `register_post_type()` |
| `lumina_api_v2_post_type_fields` | Modifier les champs ACF d’un Post Type |
| `lumina_api_v2_post_type_transformer` | Changer le Transformer d’un Post Type |
| `lumina_api_v2_icons` | Étendre le catalogue d’icônes |
| `lumina_api_v2_hubspot_form` | Modifier le payload formulaire HubSpot |
| `lumina_api_v2_wysiwyg` | Post-traitement HTML WYSIWYG |
| `lumina_api_v2_wysiwyg_internal_url` | Ajuster les chemins de liens internes |
| `lumina_api_v2_wysiwyg_home_slug` | Slug page d’accueil dans les liens WYSIWYG |
| `lumina_api_link` | Réécriture de liens (filtre thème Lumina) |
| `skeem_api_link` | Réécriture URL OG (meta Yoast) |

---

## PHP

Compatible **PHP 7.4** – **8.3**.

---

## Roadmap

- [ ] Cache Redis / transients API
- [ ] Auth JWT (routes protégées)
- [ ] Schéma OpenAPI auto
- [ ] Footer / header : variante par langue documentée dans l’admin WPML
- [ ] Consommation de `frontend_url` côté PHP (emails, redirects…)
