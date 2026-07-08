# Lumina API v2

Plugin WordPress **headless** : exposition REST JSON propre pour pages Gutenberg (ACF), layout global (header / footer) et SEO (Yoast).

---

## Prérequis

- WordPress + **ACF Pro** (blocks, options, repeaters)
- Composer (`composer install` dans le plugin)
- Recommandé : **Yoast SEO**, **WPML** (multilingue), CPT `contact-form` (thème Lumina) pour les formulaires HubSpot

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

Réponse standard :

```json
{
  "success": true,
  "data": { }
}
```

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
| `id`, `title`, `slug`, `lang` | Page WordPress |
| `acf` | Champs ACF page (brut) |
| `blocks` | Sections Gutenberg transformées (`type` + `data`) |
| `meta_data` | SEO Yoast (titre, OG, schema, breadcrumbs…) |

### Layout global

```
GET /wp-json/lumina/v2/{lang}/layout/header
GET /wp-json/lumina/v2/{lang}/layout/footer
```

Configurés dans **Theme Settings → Lumina v2** (options ACF du plugin).

---

## Multilingue (WPML)

Le segment `{lang}` de l’URL :

1. Bascule WPML (`wpml_switch_language`)
2. Applique `acf/settings/current_language` pour les **options ACF**
3. Résout les pages traduites (`wpml_object_id`) dans `PageService`

Langue par défaut : `wpml_default_language` ou `fr`.

---

## Architecture

```
lumina-api-v2/
├── lumina-api-v2.php
├── assets/
│   ├── icons/          # SVG icônes (icon_lumina)
│   └── admin/          # CSS/JS aperçu icônes ACF
├── src/
│   ├── Core/           # Plugin, Router, Config
│   ├── Controllers/    # Page, Layout (header/footer)
│   ├── Services/       # Page, Header, Footer, Meta, HubSpotForm, Language
│   ├── Transformers/   # Page, Blocks, Header, Footer
│   ├── Helpers/        # Response, Media, Button, Cta, Icon, AcfRepeater…
│   ├── Acf/            # IconRegistry, IconField, ButtonFields
│   ├── Options/        # Header, Footer (fields ACF options)
│   └── Blocks/         # Un dossier par section Gutenberg
```

Flux : **WordPress → Services / Transformers → JSON → Frontend (Next.js, etc.)**

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

**Enregistrement auto** : `Blocks\Loader` + `Blocks\TransformerRegistry` (découverte par dossier, namespace PascalCase).

### Blocks disponibles (v2)

| Block ACF | Type API |
|-----------|----------|
| `be-hero` | `hero` |
| `be-hero-main` | `hero_main` |
| `be-compliance-targets` | `compliance_targets` |
| `be-features-tabs` | `features_tabs` |
| `be-flexible-platform` | `flexible_platform` |
| `be-human-first` | `human_first` |
| `be-why-choose` | `why_choose` |
| `be-proof-section` | `proof_section` |
| `be-partners` | `partners` |
| `be-testimonials` | `testimonials` |
| `be-be-inspired` | `be_inspired` |
| `be-get-started` / CTA banner | `cta_banner` |
| `be-demo-request` | `demo_request` |

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

## Options ACF (Header & Footer)

**Admin :** Theme Settings → **Lumina v2**

### Header

- Logo, téléphone, CTA, sélecteur de langue
- Navigation : lien simple ou **mega menu** (titre, description, liens, cartes avec `icon_lumina`)

### Footer

- Logo + description
- Colonnes : liens ou **certifications** (badges)
- Copyright, liens légaux, réseaux sociaux

---

## SEO

`meta_data` sur chaque page via **Yoast** (`MetaService`), avec repli sur `CMetaData` du thème si présent.

---

## PHP

Compatible **PHP 7.4** – **8.3**.

---

## Roadmap

- [ ] Cache Redis / transients API
- [ ] Auth JWT (routes protégées)
- [ ] Schéma OpenAPI auto
- [ ] Footer / header : variante par langue documentée dans l’admin WPML
