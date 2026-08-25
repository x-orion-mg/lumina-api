<?php

use Lumina\ApiV2\Acf\ButtonFields;

if (!function_exists('acf_add_local_field_group')) {
    return;
}

$buttonFields = ButtonFields::group(
    'lumina_documentation_',
    'CTA'
);

acf_add_local_field_group([
    'key' => 'group_lumina_documentation',
    'title' => 'Lumina Documentation',

    'fields' => array_merge(
        [
            [
                'key' => 'field_lumina_documentation_subtitle',
                'label' => 'Sous-titre',
                'name' => 'subtitle',
                'type' => 'text',

                'required' => 0,

                'default_value' => '',
            ],

            [
                'key' => 'field_lumina_documentation_title',
                'label' => 'Titre',
                'name' => 'title',
                'type' => 'text',

                'required' => 1,

                'default_value' => '',
            ],
            [
                'key' => 'field_lumina_documentation_articles',
                'label' => 'Articles',
                'name' => 'articles',
                'type' => 'relationship',

                'instructions' => 'Sélectionnez jusqu’à 3 articles. Si aucun article n’est sélectionné, les articles les plus récents seront affichés automatiquement.',

                'required' => 0,

                'post_type' => [
                    'post',
                ],

                'post_status' => [
                    'publish',
                ],

                'filters' => [
                    'search',
                    'taxonomy',
                ],

                'return_format' => 'id',

                'min' => 0,

                'max' => 3,

                'elements' => [
                    'featured_image',
                ],
            ],
        ],
        $buttonFields
    ),
    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/lumina-documentation',
            ],
        ],
    ],

    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
]);