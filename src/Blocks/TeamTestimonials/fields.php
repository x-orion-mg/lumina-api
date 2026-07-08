<?php

acf_add_local_field_group([
    'key' => 'group_be_team_testimonials',
    'title' => 'Block - Rebranding Timeline',
    'fields' => array_merge([
            [
                'key' => 'field_be_team_testimonials_badge',
                'label' => 'Badge',
                'name' => 'badge',
                'type' => 'text',
                'default_value' => 'Un mot de l\'équipe',
            ],
            [
                'key' => 'field_be_team_testimonials_title',
                'label' => 'Titre',
                'name' => 'title',
                'type' => 'textarea',
                'instructions' => 'Pour appliquer un effet de dégradé (gradient) à un texte, encadrez le mot ou l\'expression avec des crochets : [votre mot].',
                'rows' => 5,
                'new_lines' => 'br',
            ],
            [
                'key' => 'field_be_team_testimonials_list_of_clients',
                'label' => 'Team Testimonials',
                'name' => 'list_of_clients',
                'type' => 'relationship',
                'post_type' => ['testimony'],
                'filters' => ['search'],
                'return_format' => 'id',
                'min' => 1,
            ],
        ]
    ),
    'location' => [[[
        'param' => 'block',
        'operator' => '==',
        'value' => 'acf/be-team-testimonials',
    ]]],
    'active' => true,
]);