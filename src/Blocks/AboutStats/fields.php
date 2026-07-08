<?php

acf_add_local_field_group([

    'key' => 'group_be_about_stats',

    'title' => 'Block - About Stats',

    'fields' => [

        [
            'key' => 'field_be_about_stats_label',
            'label' => 'Label',
            'name' => 'label',
            'type' => 'text',
            'placeholder' => 'À propos',
        ],

        [
            'key' => 'field_be_about_stats_title',
            'label' => 'Titre',
            'name' => 'title',
            'type' => 'textarea',
            'instructions' => 'Pour appliquer un effet de dégradé (gradient) à un texte, encadrez le mot ou l\'expression avec des crochets : [votre mot].',
            'rows' => 3,
            'new_lines' => 'br',
            'placeholder' => 'Nous aidons les organisations à [bâtir la confiance]',
        ],

        [
            'key' => 'field_be_about_stats_description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'textarea',
            'rows' => 5,
            'new_lines' => 'br',
        ],

        [
            'key' => 'field_be_about_stats_cards',
            'label' => 'Statistiques',
            'name' => 'cards',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Ajouter une statistique',
            'min' => 1,
            'max' => 3,
            'sub_fields' => [

                [
                    'key' => 'field_be_about_stats_card_value',
                    'label' => 'Valeur',
                    'name' => 'value',
                    'type' => 'text',
                    'placeholder' => '250+',
                ],

                [
                    'key' => 'field_be_about_stats_card_text',
                    'label' => 'Texte',
                    'name' => 'text',
                    'type' => 'textarea',
                    'rows' => 3,
                    'new_lines' => 'br',
                ],

            ],
        ],

    ],

    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/be-about-stats',
            ],
        ],
    ],

]);