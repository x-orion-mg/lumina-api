<?php

use Lumina\ApiV2\Acf\ButtonFields;

$buttonFields = ButtonFields::group('cta_career_', 'Bouton CTA');

acf_add_local_field_group([

    'key' => 'group_be_cta_career',

    'title' => 'Block - CTA Career',

    'fields' => array_merge([

        [
            'key' => 'field_be_cta_career_title',
            'label' => 'Titre',
            'name' => 'title',
            'type' => 'textarea',
            'instructions' => 'Pour appliquer un effet de dégradé (gradient) à un texte, encadrez le mot ou l\'expression avec des crochets : [votre mot].',
            'rows' => 3,
            'new_lines' => 'br',
            'placeholder' => 'Rejoignez l\'aventure',
        ],

        [
            'key' => 'field_be_cta_career_description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'textarea',
            'rows' => 4,
            'new_lines' => 'br',
        ],

    ], $buttonFields),

    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/be-cta-career',
            ],
        ],
    ],

]);
