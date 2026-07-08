<?php

acf_add_local_field_group( array(
    'key' => 'group_6a0c3ccb7cadb',
    'title' => '[Section v2] - Liste partenaires',
    'fields' => array(
        array(
            'key' => 'field_6a0c3ccc18180',
            'label' => 'Title',
            'name' => 'title',
            'aria-label' => '',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'wpml_cf_preferences' => 2,
            'default_value' => '',
            'maxlength' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
        ),
        array(
            'key' => 'field_6a0c3cfa18181',
            'label' => 'Liste des partenaires',
            'name' => 'list_of_partners',
            'aria-label' => '',
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
                0 => 'partner',
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
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/be-partners',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
    'acfml_field_group_mode' => 'advanced',
) );

