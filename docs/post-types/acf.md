# Post Types & ACF

Lumina API v2 propose une architecture modulaire pour les Post Types et leurs champs **ACF Pro**.

L'objectif est de pouvoir :

- définir les champs ACF directement dans le dossier du Post Type ;
- séparer les groupes ACF en plusieurs fichiers ;
- réutiliser un même groupe ACF sur plusieurs Post Types ;
- générer automatiquement les règles `location` ACF ;
- conserver des clés ACF stables ;
- activer/désactiver les Post Types depuis l'administration ;
- ne pas enregistrer les groupes ACF d'un Post Type désactivé ;
- conserver les groupes partagés lorsqu'ils sont encore utilisés par un Post Type actif ;
- éviter tout `add_action('acf/include_fields', ...)` dans les fichiers ACF ;
- conserver le fonctionnement standard de `get_field()` et `get_fields()`.

---

## Architecture

La gestion des Post Types suit le principe :

```text
PostTypeDefinition
        ↓
PostTypeRegistry
        ↓
PostTypeRegistration
        ↓
CPT + ACF
```
## La gestion des ACF est maintenant séparée dans un système dédié :
```text
Post Type
↓
acfGroups()
↓
AcfRegistry
↓
AcfLoader
↓
acf_add_local_field_group()
```
## Structure

```text
src/
└── PostTypes/
    │
    ├── Acf/
    │   ├── AcfGroup.php
    │   ├── AcfRegistry.php
    │   ├── AcfLoader.php
    │   └── Shared/
    │       ├── Seo.php
    │       ├── Media.php
    │       └── Information.php
    │
    ├── Definitions/
    │   ├── Product/
    │   │   ├── Definition.php
    │   │   ├── Acf/
    │   │   │   ├── ProductInformation.php
    │   │   │   └── ProductMedia.php
    │   │   └── Transformer.php
    │   │
    │   ├── Solution/
    │   │   ├── Definition.php
    │   │   ├── Acf/
    │   │   │   └── SolutionInformation.php
    │   │   └── Transformer.php
    │   │
    │   └── Event/
    │       ├── Definition.php
    │       ├── Acf/
    │       │   └── EventInformation.php
    │       └── Transformer.php
    │
    ├── PostTypeDefinition.php
    ├── PostTypeRegistry.php
    ├── PostTypeRegistration.php
    └── ...
```
## 1. Définir un groupe ACF

Chaque groupe ACF est défini dans une classe PHP.

Exemple :
src/PostTypes/Definitions/Product/Acf/ProductInformation.php

```php
<?php

namespace Lumina\ApiV2\PostTypes\Definitions\Product\Acf;

final class ProductInformation
{
    public static function key(): string
    {
        return 'group_lumina_product_information';
    }

    public static function title(): string
    {
        return '[Produits] - Informations';
    }

    public static function fields(): array
    {
        return [
            [
                'key' => 'field_lumina_youtube_video_url',
                'label' => 'Lien vidéo YouTube',
                'name' => 'youtube_video_url',
                'type' => 'link',
                'instructions' => 'URL complète de la vidéo YouTube.',
                'required' => 0,
                'return_format' => 'array',
            ],

            [
                'key' => 'field_lumina_legrand_product_url',
                'label' => 'Lien produit Legrand',
                'name' => 'legrand_product_url',
                'type' => 'link',
                'instructions' => 'URL de la fiche produit sur le site Legrand.',
                'required' => 0,
                'return_format' => 'array',
            ],

            [
                'key' => 'field_lumina_technical_specs',
                'label' => 'Caractéristiques techniques',
                'name' => 'technical_specs',
                'type' => 'wysiwyg',
                'instructions' => 'Tableau ou liste des caractéristiques techniques du produit.',
                'required' => 0,
                'toolbar' => 'full',
                'media_upload' => 1,
            ],
        ];
    }
}
```
Il n'est pas nécessaire d'écrire :
```php
add_action('acf/include_fields', function () {
    ...
});
```
Le **AcfLoader** s'en charge automatiquement.

## 2. Déclarer les groupes dans un Post Type
Le Post Type déclare les groupes ACF qu'il utilise.

Exemple : src/PostTypes/Definitions/Product/Definition.php
```php
<?php

namespace Lumina\ApiV2\PostTypes\Definitions\Product;

use Lumina\ApiV2\PostTypes\PostTypeDefinition;
use Lumina\ApiV2\PostTypes\Definitions\Product\Acf\ProductInformation;
use Lumina\ApiV2\PostTypes\Acf\Shared\Seo;
use Lumina\ApiV2\PostTypes\Acf\Shared\Media;

final class Definition extends PostTypeDefinition
{
    public function key(): string
    {
        return 'product';
    }

    public function args(): array
    {
        return [
            // Configuration du CPT.
        ];
    }

    public function acfGroups(): array
    {
        return [
            ProductInformation::class,
            Seo::class,
            Media::class,
        ];
    }
}
```
Le système détecte automatiquement les classes ACF déclarées par le Post Type.

## 3. Groupes ACF partagés
Un groupe ACF peut être utilisé par plusieurs Post Types.

Les groupes partagés doivent être placés dans : src/PostTypes/Acf/Shared/

Exemple : src/PostTypes/Acf/Shared/Seo.php
```php
<?php

namespace Lumina\ApiV2\PostTypes\Acf\Shared;

final class Seo
{
    public static function key(): string
    {
        return 'group_lumina_shared_seo';
    }

    public static function title(): string
    {
        return 'SEO';
    }

    public static function fields(): array
    {
        return [
            [
                'key' => 'field_lumina_seo_title',
                'label' => 'Titre SEO',
                'name' => 'seo_title',
                'type' => 'text',
            ],

            [
                'key' => 'field_lumina_seo_description',
                'label' => 'Description SEO',
                'name' => 'seo_description',
                'type' => 'textarea',
            ],
        ];
    }
}
```

## 4. Utiliser un groupe partagé
Supposons que le groupe **Seo** soit utilisé par :

* Product
* Solution
* Event
* Product


```php
use Lumina\ApiV2\PostTypes\Acf\Shared\Seo;

public function acfGroups(): array
{
    return [
        Seo::class,
    ];
}
```

Solution

```php
use Lumina\ApiV2\PostTypes\Acf\Shared\Seo;

public function acfGroups(): array
{
    return [
        Seo::class,
    ];
}
```
Le groupe n'est pas copié et n'est pas enregistré trois fois.

Le système construit automatiquement une seule définition ACF avec plusieurs locations :
```php
[
    'key' => 'group_lumina_shared_seo',

    'title' => 'SEO',

    'fields' => [
        // ...
    ],

    'location' => [
        [
            [
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'product',
            ],
        ],
        [
            [
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'solution',
            ],
        ],
        [
            [
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'event',
            ],
        ],
    ],
]
```
## 5. Pourquoi utiliser ```Shared/``` ?
Utiliser Shared/ lorsqu'un groupe possède exactement le même rôle et les mêmes champs pour plusieurs Post Types.

Exemple :
```
src/PostTypes/Acf/Shared/
├── Seo.php
├── Media.php
├── Information.php
└── Documents.php
```

Puis :
```
Product
 ├── Shared\Seo
 ├── Shared\Media
 └── ProductInformation

Solution
 ├── Shared\Seo
 ├── Shared\Media
 └── SolutionInformation

Event
 └── Shared\Seo
```
Cela évite :
````
Product/Acf/Seo.php
Solution/Acf/Seo.php
Event/Acf/Seo.php
````
avec trois copies du même code.

## 6. Groupe spécifique à un Post Type
Si les champs sont propres à un seul Post Type, ils doivent rester dans son dossier.

Exemple :
```
src/PostTypes/Definitions/Product/Acf/ProductInformation.php
src/PostTypes/Definitions/Product/Acf/ProductMedia.php
src/PostTypes/Definitions/Solution/Acf/SolutionInformation.php
src/PostTypes/Definitions/Event/Acf/EventInformation.php
```
## 7. Détection automatique

La découverte des Post Types reste automatique.

Il n'est pas nécessaire de modifier :
```
Router.php
ContentController.php
```
lorsqu'un nouveau Post Type est ajouté.

Exemple :
```
src/PostTypes/Definitions/Customer/
├── Definition.php
├── Acf/
│   ├── Information.php
│   └── Company.php
└── Transformer.php
```
Une fois le Post Type découvert et activé, ses groupes ACF sont également découverts.

## 8. Activation / désactivation

Les Post Types peuvent toujours être activés depuis :
```
Theme Settings
└── Lumina v2
└── Post Types
```
Lorsqu'un Post Type est désactivé :

le CPT n'est pas enregistré ;
ses groupes ACF spécifiques ne sont pas enregistrés ;
ses groupes ACF partagés restent enregistrés s'ils sont utilisés par un autre Post Type actif ;
aucune donnée existante n'est supprimée.
Exemple
```
SEO
├── Product
├── Solution
└── Event
```
Si :
```
Product = actif
Solution = désactivé
Event = désactivé
```
le groupe SEO reste disponible pour :

Product

La location devient :
```php

[
    [
        [
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'product',
        ],
    ],
]
```
## 9. Aucun Post Type actif

Si :
```
Product = désactivé
Solution = désactivé
Event = désactivé
```
et que le groupe :
```
Shared\Seo
```
n'est utilisé par aucun autre Post Type actif, il n'est pas enregistré.

Les données précédemment enregistrées dans WordPress ne sont pas supprimées.

## 10. Clés ACF

Les clés ACF doivent être stables.

Il ne faut jamais générer une clé aléatoire à chaque chargement.

Groupe

Correct :
```php
public static function key(): string
{
return 'group_lumina_product_information';
}
```
Incorrect :
```php
return uniqid();
```
ou :
```php
return 'group_' . md5(time());
```
Field

Correct :
```php
[
'key' => 'field_lumina_youtube_video_url',
'name' => 'youtube_video_url',
// ...
]
```
Incorrect :
```php
[
'key' => uniqid('field_'),
// ...
]
```
Les clés ACF sont utilisées par WordPress/ACF pour identifier les groupes et champs existants.

Ne pas modifier une clé existante sans raison.

Lorsqu'un groupe existant est migré vers cette architecture, il faut conserver sa clé actuelle.

## 11. Migration d'un groupe ACF existant

Si un groupe existant possède :
```
'key' => 'group_6a7c8a64d8f57'
```
ne pas le remplacer par :
```
'key' => 'group_lumina_product_information'
```
si le groupe est déjà utilisé en production.

Il faut conserver :
```
'key' => 'group_6a7c8a64d8f57'
```
et conserver également les clés existantes des fields.

Exemple :
```php
final class ProductInformation
{
    public static function key(): string
    {
    return 'group_6a7c8a64d8f57';
    }


    public static function fields(): array
    {
        return [
            [
                'key' => 'field_6a7c8a68f3973',
                'name' => 'youtube_video_url',
                // ...
            ],
        ];
    }
}
```
Cette règle est importante pour éviter une rupture avec les données ACF existantes.

## 12. Location automatique

Par défaut, il n'est pas nécessaire d'écrire :
```php
'location' => [
    [
        [
        'param' => 'post_type',
        'operator' => '==',
        'value' => 'product',
        ],
    ],
],
```
Le système détermine automatiquement les Post Types utilisant le groupe.

Par exemple :
```php
final class Seo
{
    public static function key(): string
    {
    return 'group_lumina_shared_seo';
    }


    public static function title(): string
    {
        return 'SEO';
    }


    public static function fields(): array
    {
        return [
            // ...
        ];
    }
}
```
Si :
```
Product → Seo
Solution → Seo
Event → Seo
```
le loader génère automatiquement les trois règles de location.

## 13. Location personnalisée

Un groupe peut également fournir sa propre location.

Exemple :
```php
final class ProductSettings
{
    public static function key(): string
    {
    return 'group_lumina_product_settings';
    }


    public static function title(): string
    {
        return 'Réglages produit';
    }


    public static function fields(): array
    {
        return [
            // ...
        ];
    }


    public static function location(): array
    {
        return [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                ],
            ],
        ];
    }
}
```
Dans ce cas, le loader utilise la location explicitement fournie.

La location automatique reste le comportement recommandé pour les groupes partagés.

## 14. Format des classes ACF

Un groupe ACF doit idéalement exposer :
```php
public static function key(): string;
public static function title(): string;
public static function fields(): array;
```
Exemple minimal :
```php
final class Information
{
    public static function key(): string
    {
    return 'group_lumina_information';
    }


    public static function title(): string
    {
        return 'Informations';
    }


    public static function fields(): array
    {
        return [
            [
                'key' => 'field_lumina_description',
                'label' => 'Description',
                'name' => 'description',
                'type' => 'textarea',
            ],
        ];
    }
}
```
## 15. Paramètres ACF supplémentaires

Les méthodes ```key(), title() et fields()``` représentent le minimum.

Les groupes peuvent également fournir une configuration supplémentaire selon les besoins du projet.

Par exemple :
```php
public static function config(): array
{
    return [
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    ];
}
```
Le loader fusionne cette configuration avec les champs et les locations générées.

## 16. Exemple complet Product

Structure :
```
src/PostTypes/
├── Acf/
│   └── Shared/
│       ├── Seo.php
│       └── Media.php
│
└── Definitions/
└── Product/
├── Definition.php
├── Acf/
│   └── ProductInformation.php
└── Transformer.php
```
ProductInformation.php
```php
<?php


namespace Lumina\ApiV2\PostTypes\Definitions\Product\Acf;


final class ProductInformation
{
    public static function key(): string
    {
        return 'group_lumina_product_information';
    }


    public static function title(): string
    {
        return '[Produits] - Informations';
    }


    public static function fields(): array
    {
        return [
            [
                'key' => 'field_lumina_youtube_video_url',
                'label' => 'Lien vidéo YouTube',
                'name' => 'youtube_video_url',
                'type' => 'link',
                'return_format' => 'array',
            ],


            [
                'key' => 'field_lumina_legrand_product_url',
                'label' => 'Lien produit Legrand',
                'name' => 'legrand_product_url',
                'type' => 'link',
                'return_format' => 'array',
            ],


            [
                'key' => 'field_lumina_technical_specs',
                'label' => 'Caractéristiques techniques',
                'name' => 'technical_specs',
                'type' => 'wysiwyg',
                'toolbar' => 'full',
                'media_upload' => 1,
            ],
        ];
    }
}
```
Definition.php
```php
<?php


namespace Lumina\ApiV2\PostTypes\Definitions\Product;


use Lumina\ApiV2\PostTypes\PostTypeDefinition;
use Lumina\ApiV2\PostTypes\Acf\Shared\Seo;
use Lumina\ApiV2\PostTypes\Acf\Shared\Media;
use Lumina\ApiV2\PostTypes\Definitions\Product\Acf\ProductInformation;


final class Definition extends PostTypeDefinition
{
    public function key(): string
    {
        return 'product';
    }


    public function args(): array
    {
        return [
            'label' => 'Produits',
            'public' => true,
            'show_in_rest' => true,
        ];
    }


    public function acfGroups(): array
    {
        return [
            ProductInformation::class,
            Seo::class,
            Media::class,
        ];
    }
}
```
## 17. Exemple complet de groupe partagé Product + Solution

Créons :
```
src/PostTypes/Acf/Shared/Seo.php
```
```php
<?php


namespace Lumina\ApiV2\PostTypes\Acf\Shared;


final class Seo
{
    public static function key(): string
    {
        return 'group_lumina_shared_seo';
    }


    public static function title(): string
    {
        return 'SEO';
    }


    public static function fields(): array
    {
        return [
            [
                'key' => 'field_lumina_seo_title',
                'label' => 'Titre SEO',
                'name' => 'seo_title',
                'type' => 'text',
            ],


            [
                'key' => 'field_lumina_seo_description',
                'label' => 'Description SEO',
                'name' => 'seo_description',
                'type' => 'textarea',
            ],
        ];
    }
}
```
Product
```php
use Lumina\ApiV2\PostTypes\Acf\Shared\Seo;


public function acfGroups(): array
{
    return [
        Seo::class,
    ];
}
Solution
use Lumina\ApiV2\PostTypes\Acf\Shared\Seo;


public function acfGroups(): array
{
    return [
        Seo::class,
    ];
}
```
Résultat :
```
                    ┌── Product
                    │
Shared\Seo ─────────┼── Solution
                    │
                    └── Event
```
Un seul groupe ACF est enregistré.

## 18. Données ACF dans les Transformers

Cette architecture ne modifie pas le fonctionnement d'ACF.

Les Transformers continuent à utiliser :
```php
get_field('youtube_video_url', $post_id);
```
ou :
```php
get_fields($post_id);
```
Exemple :

public function transform($post): array
{
    $data = get_fields($post->ID);


    return [
        'id' => $post->ID,
        'title' => get_the_title($post),
        'acf' => $data,
    ];
}

Les données restent donc compatibles avec l'API REST existante.

## 19. Compatibilité avec l'API REST

La nouvelle gestion ACF ne modifie pas les endpoints existants.

Par exemple :
```
GET /wp-json/lumina/v2/fr/content/product/my-product
```
continue de retourner les données ACF du Post Type.

La réponse peut contenir :
```json
{
    "id": 123,
    "post_type": "product",
    "title": "Mon produit",
    "acf": {
        "youtube_video_url": {
            "url": "https://www.youtube.com/watch?v=..."
        },
        "legrand_product_url": {
            "url": "https://..."
        },
        "technical_specs": "<p>...</p>",
        "seo_title": "Mon produit"
    }
}
```
## 20. Filtre Post Type existant

Le filtre existant :
```
lumina_api_v2_post_type_fields
```
doit rester disponible.

Il permet à une extension ou au thème de modifier les champs d'un Post Type.

Exemple :
```php
add_filter(
    'lumina_api_v2_post_type_fields',
    function ($fields, $postType) {


        if ($postType !== 'product') {
            return $fields;
        }


        $fields[] = [
            'key' => 'field_custom_product_code',
            'label' => 'Code produit',
            'name' => 'product_code',
            'type' => 'text',
        ];


        return $fields;
    },
    10,
    2
);
```
## 21. Filtres ACF

L'architecture peut également exposer des filtres spécifiques aux groupes.

Les filtres doivent permettre notamment de :

* modifier les groupes ;
* modifier les champs ;
* modifier les locations ;
* ajouter des groupes ;
* supprimer des groupes.

Exemples :
```
lumina_api_v2_acf_groups
lumina_api_v2_post_type_acf_groups
lumina_api_v2_acf_field_group
```
Les filtres existants du plugin doivent être conservés lorsque leur rôle est déjà utilisé par des intégrations existantes.

## 22. ACF Pro obligatoire pour les groupes ACF

Le loader vérifie la disponibilité d'ACF avant d'enregistrer les groupes.

Le comportement attendu est équivalent à :
```php
if (!function_exists('acf_add_local_field_group')) {
    return;
}
```
```
Ainsi, si ACF Pro est désactivé :

Lumina API v2
      ↓
Post Types
      ↓
AcfLoader
      ↓
ACF indisponible
      ↓
aucune erreur fatale
```
Le plugin peut continuer à charger ses autres fonctionnalités.

## 23. Compatibilité WPML

La nouvelle architecture ne modifie pas la gestion WPML.

Les champs ACF continuent à être gérés par ACF/WPML selon la configuration du site.

La registration des groupes ACF reste centralisée et indépendante du changement de langue.

Les services existants responsables de :

* ```wpml_switch_language```
* ```acf/settings/current_language```
* résolution des traductions

ne doivent pas être remplacés par le système ACF.

## 24. WooCommerce

Les intégrations WooCommerce qui utilisent les groupes ACF doivent utiliser les clés publiques du groupe.

Par exemple :
```php
ProductInformation::key()
```
plutôt que d'appeler une méthode inexistante ou de dupliquer la clé :
```php
ProductInformation::groupKey()
```
Si une intégration existante utilise une ancienne méthode, elle doit être adaptée au nouveau contrat du groupe ACF.

Exemple :
```php
use Lumina\ApiV2\PostTypes\Definitions\Product\Acf\ProductInformation;
```
```php
$groupKey = ProductInformation::key();
```
## 25. Ajouter un nouveau Post Type

Pour ajouter un Post Type :

#### Étape 1

Créer :
```
src/PostTypes/Definitions/Customer/
```
#### Étape 2

Ajouter :
```
Definition.php
```

#### Étape 3

Ajouter éventuellement :

Acf/
#### Étape 4

Ajouter les groupes nécessaires :
```
Acf/
├── Information.php
├── Company.php
└── Contact.php
```
#### Étape 5

Déclarer les groupes dans :
```php
public function acfGroups(): array
{
    return [
        Information::class,
        Company::class,
        Contact::class,
    ];
}
```
#### Étape 6

Activer le Post Type depuis :
```
Theme Settings → Lumina v2 → Post Types
```
Aucune modification de :
```
Router.php
ContentController.php
```
n'est nécessaire.

## 26. Quand utiliser Shared ?

Utiliser :
```
src/PostTypes/Acf/Shared/
```
lorsque les champs sont réellement communs.

Exemple :
```
Shared/Seo.php
```
utilisé par :
```
Product
Solution
Event
Partner
```
Utiliser :
```
Definitions/Product/Acf/
```
lorsque le groupe est spécifique à Product.

Exemple :
```
Product/Acf/ProductInformation.php
```
## 27. Règle importante : une clé = un groupe

Une même clé ACF doit toujours représenter le même groupe logique.

Correct :
```
group_lumina_shared_seo
        ↓
SEO partagé

Incorrect :

group_lumina_shared_seo
        ↓
Product fields aujourd'hui
        ↓
Solution fields demain
```
Une clé existante ne doit pas être réutilisée pour un groupe ayant une structure différente.

## 28. Tests recommandés

Le système doit couvrir au minimum les cas suivants.

#### Groupe simple
```
Product
└── Information
```
Vérifier que le groupe est enregistré avec :
```
product
```
comme location.

Plusieurs groupes
```
Product
├── Information
├── Media
└── SEO
```
Les trois groupes doivent être enregistrés.

Groupe partagé
```
SEO
├── Product
├── Solution
└── Event
```
Un seul groupe doit être enregistré avec trois locations.

Désactivation

Si :
```
Product = désactivé
Solution = actif
```
le groupe partagé reste enregistré avec :

solution

uniquement.

Aucun Post Type actif

Le groupe partagé ne doit pas être enregistré.

ACF absent

Aucune erreur fatale ne doit être générée.

Clés stables

Deux chargements successifs doivent produire les mêmes :

group keys
field keys
API

Les données ACF doivent continuer à être disponibles dans :
```
GET /wp-json/lumina/v2/{lang}/content/{post_type}/{slug}
```
## 29. Bonnes pratiques
Toujours utiliser des clés explicites
```
'group_lumina_product_information'
```
et :
```
'field_lumina_product_video'
```
plutôt que des clés générées dynamiquement.

Un fichier = un groupe

Préférer :
```
Acf/
├── Information.php
├── Media.php
└── Seo.php
```
plutôt qu'un fichier contenant tous les groupes.

Réutiliser les groupes communs

Préférer :
```
Shared/Seo.php
```
à plusieurs copies de :
```
Product/Acf/Seo.php
Solution/Acf/Seo.php
Event/Acf/Seo.php
```
Ne pas mettre la logique métier dans les groupes

Les classes ACF doivent principalement décrire :
```
key
title
fields
location/configuration
```
La transformation des données reste dans les :

Transformer.php
## 30. Résumé

La nouvelle architecture permet d'obtenir :
```
                    ┌── Product
                    │
Shared ACF ─────────┼── Solution
                    │
                    └── Event
```
avec :
```
1 groupe ACF
1 clé stable
N Post Types
N locations générées automatiquement
```
et :
```
PostTypeDefinition
        ↓
acfGroups()
        ↓
AcfRegistry
        ↓
AcfLoader
        ↓
acf_add_local_field_group()
```
Les avantages sont :
* 
* pas de duplication ;
* découverte automatique ;
* groupes ACF modulaires ;
* groupes partagés ;
* locations générées automatiquement ;
* clés stables ;
* compatibilité ACF Pro ;
* compatibilité PHP 7.4 → 8.3 ;
* compatibilité avec les Transformers existants ;
* compatibilité avec l'API REST existante ;
* gestion correcte des Post Types activés/désactivés ;
* migration progressive possible sans perte de données.
* Cette architecture constitue la convention recommandée pour tous les nouveaux Post Types Lumina API v2.