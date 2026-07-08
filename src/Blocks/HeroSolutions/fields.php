<?php

use Lumina\ApiV2\Acf\ButtonFields;

$primaryButtonFields = ButtonFields::group(
    'primary_cta_',
    'Bouton principal'
);
$secondaryButtonFields = ButtonFields::group('secondary_cta_', 'Bouton secondaire');

acf_add_local_field_group([
    'key'      => 'group_be_hero_enterprise',
    'title'    => 'Block - Hero Solutions',
    'fields'   => array_merge([
        [
            'key' => 'field_be_hero_solutions_badge',
            'label' => 'Badge',
            'name' => 'badge',
            'type' => 'text',
            'instructions' => 'Exemple : Pour les entreprises 50+',
        ],
        [
            'key'   => 'field_be_hero_solutions_title',
            'label' => 'Titre',
            'name'  => 'title',
            'type'  => 'textarea',
            'instructions' => 'Pour appliquer un effet de dégradé (gradient) à un texte, encadrez le mot ou l\'expression avec des crochets : [votre mot].',
            'rows'  => 4,
            'new_lines' => 'br',
        ],
        [
            'key' => 'field_be_hero_solutions_description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'textarea',
            'rows' => 5,
            'new_lines' => 'br',
        ],
    ],
        $primaryButtonFields,
        $secondaryButtonFields,
    ),
    'location' => [[[
        'param'    => 'block',
        'operator' => '==',
        'value'    => 'acf/be-hero-solutions',
    ]]],
    'active'   => true,
]);