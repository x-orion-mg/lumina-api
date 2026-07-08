<?php

use Lumina\ApiV2\Acf\ButtonFields;

$primaryButtonFields = ButtonFields::group(
    'primary_cta_',
    'Bouton principal'
);

$secondaryButtonFields = ButtonFields::group(
    'secondary_cta_',
    'Bouton secondaire'
);

acf_add_local_field_group([
    'key'    => 'group_be_cta_community',
    'title'  => 'Block - CTA Community',
    'fields' => array_merge([
        [
            'key'           => 'field_be_cta_community_eyebrow',
            'label'         => 'Eyebrow',
            'name'          => 'eyebrow',
            'type'          => 'text',
        ],
        [
            'key'           => 'field_be_cta_community_title',
            'label'         => 'Titre',
            'name'          => 'title',
            'type'          => 'textarea',
            'instructions'  => 'Pour appliquer un effet de dégradé (gradient) à un texte, encadrez le mot ou l\'expression avec des crochets : [votre mot].',
            'rows'          => 3,
            'new_lines'     => 'br',
        ],
        [
            'key'           => 'field_be_cta_community_description',
            'label'         => 'Description',
            'name'          => 'description',
            'type'          => 'textarea',
            'rows'          => 4,
            'new_lines'     => 'br',
        ],
    ], $primaryButtonFields, $secondaryButtonFields),
    'location' => [[[
        'param'    => 'block',
        'operator' => '==',
        'value'    => 'acf/be-cta-community',
    ]]],
    'active' => true,
]);