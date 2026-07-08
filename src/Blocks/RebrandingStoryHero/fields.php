<?php

use Lumina\ApiV2\Acf\ButtonFields;

$primaryButtonFields = ButtonFields::group('primary_', 'Bouton principal');
$secondaryButtonFields = ButtonFields::group('secondary_', 'Bouton secondaire');

acf_add_local_field_group([
    'key'    => 'group_be_rebranding_story_hero',
    'title'  => 'Block - Rebranding Story Hero',
    'fields' => array_merge([
        [
            'key'           => 'field_be_rebranding_story_hero_badge',
            'label'         => 'Badge',
            'name'          => 'badge',
            'type'          => 'text',
            'default_value' => 'L\'HISTOIRE DU REBRANDING',
        ],
        [
            'key'          => 'field_be_rebranding_story_hero_title',
            'label'        => 'Titre',
            'name'         => 'title',
            'type'         => 'textarea',
            'instructions' => 'Pour appliquer un effet de dégradé (gradient) à un texte, encadrez le mot ou l\'expression avec des crochets : [votre mot].',
            'rows'         => 5,
            'new_lines'    => 'br',
        ],
        [
            'key'          => 'field_be_rebranding_story_hero_description',
            'label'        => 'Description',
            'name'         => 'description',
            'type'         => 'textarea',
            'rows'         => 5,
            'new_lines'    => 'br',
        ],
        [
            'key'           => 'field_be_rebranding_story_hero_features',
            'label'         => 'Points forts',
            'name'          => 'features',
            'type'          => 'repeater',
            'layout'        => 'table',
            'button_label'  => 'Ajouter un point fort',
            'min'           => 1,
            'max'           => 6,
            'sub_fields'    => [
                [
                    'key'   => 'field_be_rebranding_story_hero_features_icon',
                    'label' => 'Icône',
                    'name'  => 'icon_lumina',
                    'type'  => 'select',
                    'ui'    => 1,
                    'allow_null' => 1,
                    'return_format' => 'value',
                ],
                [
                    'key'   => 'field_be_rebranding_story_hero_features_label',
                    'label' => 'Texte',
                    'name'  => 'label',
                    'type'  => 'text',
                ],
            ],
        ],
        [
            'key'          => 'field_be_rebranding_story_hero_card_so_far',
            'label'        => 'Description carte',
            'name'         => 'description_card',
            'type'         => 'text',
            'default_value'=> 'depuis 2016 · réinventée en 2023',
        ],
        [
            'key'          => 'field_be_rebranding_story_hero_card_new_name',
            'label'        => 'Nouveau nom',
            'name'         => 'new_name',
            'type'         => 'text',
            'default_value'=> 'Lumina',
        ],
        [
            'key'          => 'field_be_rebranding_story_hero_card_label',
            'label'        => 'Label carte',
            'name'         => 'card_label',
            'type'         => 'text',
            'default_value'=> 'AUJOURD\'HUI',
        ],
        [
            'key'           => 'field_be_rebranding_story_hero_stats',
            'label'         => 'Statistiques',
            'name'          => 'stats',
            'type'          => 'repeater',
            'layout'        => 'block',
            'button_label'  => 'Ajouter une statistique',
            'min'           => 1,
            'max'           => 4,
            'sub_fields'    => [
                [
                    'key'   => 'field_be_rebranding_story_hero_stats_label',
                    'label' => 'Label',
                    'name'  => 'label',
                    'type'  => 'text',
                ],
                [
                    'key'   => 'field_be_rebranding_story_hero_stats_value',
                    'label' => 'Valeur',
                    'name'  => 'value',
                    'type'  => 'text',
                ],
            ],
        ],
    ], $primaryButtonFields, $secondaryButtonFields),
    'location' => [[[
        'param'    => 'block',
        'operator' => '==',
        'value'    => 'acf/be-rebranding-story-hero',
    ]]],
    'active' => true,
]);