<?php

acf_add_local_field_group([

    'key' => 'group_be_testimonials',

    'title' => 'Block - Testimonials',

    'fields' => [

        [
            'key' => 'field_be_testimonials_tag',
            'label' => 'Tag',
            'name' => 'tag',
            'type' => 'text',
        ],

        [
            'key' => 'field_be_testimonials_title',
            'label' => 'Title',
            'name' => 'title',
            'type' => 'textarea',
            'instructions' => 'Pour appliquer un effet de dégradé (gradient) à un texte, encadrez le mot ou l\'expression avec des crochets : [votre mot].',
            'rows' => 3,
            'new_lines' => 'br',
            'placeholder' => 'Exemple : Nous aidons les organisations à [bâtir la confiance].',
        ],

        [
            'key' => 'field_be_testimonials_description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'textarea',
            'rows' => 2,
            'new_lines' => 'br',
        ],

        [
            'key' => 'field_be_testimonials_items',
            'label' => '    Testimonials',
            'name' => 'list_of_clients',
            'type' => 'relationship',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'wpml_cf_preferences' => 2,
            'post_type' => array(
                0 => 'testimony',
            ),
            'post_status' => array(
                0 => 'publish',
            ),
            'taxonomy' => '',
            'filters' => array(
                0 => 'search',
            ),
            'return_format' => 'id',
            'min' => '',
            'max' => '',
            'elements' => '',
        ],

    ],

    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/be-testimonials',
            ],
        ],
    ],

]);