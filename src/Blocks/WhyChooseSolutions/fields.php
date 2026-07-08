<?php

acf_add_local_field_group([
    'key'      => 'group_be_why_choose_solutions',
    'title'    => 'Block - Why Choose Solutions',
    'fields'   => [

        [
            'key'           => 'field_be_why_choose_solutions_title',
            'label'         => 'Titre',
            'name'          => 'title',
            'type'          => 'textarea',
            'instructions'  => 'Pour appliquer un effet de dégradé (gradient) à un texte, encadrez le mot ou l\'expression avec des crochets : [votre mot].',
            'rows'          => 3,
            'new_lines'     => 'br',
        ],

        [
            'key'           => 'field_be_why_choose_solutions_items',
            'label'         => 'Cartes',
            'name'          => 'items',
            'type'          => 'repeater',
            'layout'        => 'block',
            'button_label'  => 'Ajouter une carte',
            'min'           => 1,
            'max'           => 6,
            'sub_fields'    => [
                [
                    'key'           => 'field_be_why_choose_solutions_items_title',
                    'label'         => 'Titre',
                    'name'          => 'title',
                    'type'          => 'text',
                ],

                [
                    'key'           => 'field_be_why_choose_solutions_items_description',
                    'label'         => 'Description',
                    'name'          => 'description',
                    'type'          => 'textarea',
                    'rows'          => 4,
                    'new_lines'     => 'br',
                ],

            ],
        ],

    ],
    'location' => [[[
        'param'    => 'block',
        'operator' => '==',
        'value'    => 'acf/be-why-choose-solutions',
    ]]],
    'active'   => true,
]);