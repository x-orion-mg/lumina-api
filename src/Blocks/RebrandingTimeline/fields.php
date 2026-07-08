<?php

use Lumina\ApiV2\Acf\ButtonFields;

$buttonFields = ButtonFields::group('timeline_', 'Bouton');

acf_add_local_field_group([
    'key'    => 'group_be_rebranding_timeline',
    'title'  => 'Block - Rebranding Timeline',
    'fields' => array_merge([
        [
            'key'           => 'field_be_rebranding_timeline_badge',
            'label'         => 'Badge',
            'name'          => 'badge',
            'type'          => 'text',
            'default_value' => 'POURQUOI CE REBRANDING',
        ],
        [
            'key'          => 'field_be_rebranding_timeline_title',
            'label'        => 'Titre',
            'name'         => 'title',
            'type'         => 'textarea',
            'instructions' => 'Pour appliquer un effet de dégradé (gradient) à un texte, encadrez le mot ou l\'expression avec des crochets : [votre mot].',
            'rows'         => 5,
            'new_lines'    => 'br',
        ],
        [
            'key'          => 'field_be_rebranding_timeline_description',
            'label'        => 'Description',
            'name'         => 'description',
            'type'         => 'textarea',
            'rows'         => 5,
            'new_lines'    => 'br',
        ],
        [
            'key'          => 'field_be_rebranding_timeline_items',
            'label'        => 'Étapes de la timeline',
            'name'         => 'items',
            'type'         => 'repeater',
            'layout'       => 'block',
            'button_label' => 'Ajouter une étape',
            'min'          => 1,
            'sub_fields'   => [
                [
                    'key'   => 'field_be_rebranding_timeline_item_year',
                    'label' => 'Année / Label',
                    'name'  => 'year',
                    'type'  => 'text',
                ],
                [
                    'key'   => 'field_be_rebranding_timeline_item_icon',
                    'label' => 'Icône',
                    'name'  => 'icon_lumina',
                    'type'  => 'select',
                    'ui'    => 1,
                    'allow_null' => 1,
                    'return_format' => 'value',
                ],
                [
                    'key'   => 'field_be_rebranding_timeline_item_title',
                    'label' => 'Titre',
                    'name'  => 'title',
                    'type'  => 'text',
                ],
                [
                    'key'   => 'field_be_rebranding_timeline_item_description',
                    'label' => 'Description',
                    'name'  => 'description',
                    'type'  => 'textarea',
                    'rows'  => 4,
                    'new_lines' => 'br',
                ],
            ],
        ],
    ], $buttonFields),
    'location' => [[[
        'param'    => 'block',
        'operator' => '==',
        'value'    => 'acf/be-rebranding-timeline',
    ]]],
    'active' => true,
]);