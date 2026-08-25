<?php

if (!function_exists('acf_add_local_field_group')) {
    return;
}

acf_add_local_field_group([
    'key' => 'group_lumina_testimonials',
    'title' => 'Lumina Testimonials',

    'fields' => [

        /*
         * ==========================================================
         * TITRE
         * ==========================================================
         */
        [
            'key' => 'field_lumina_testimonials_title',
            'label' => 'Titre',
            'name' => 'title',
            'type' => 'text',

            'required' => 1,

            'default_value' => '',
        ],

        /*
         * ==========================================================
         * TÉMOIGNAGES
         * ==========================================================
         */
        [
            'key' => 'field_lumina_testimonials_testimonials',
            'label' => 'Témoignages',
            'name' => 'testimonials',
            'type' => 'relationship',

            'instructions' => 'Sélectionnez jusqu’à 3 témoignages. Si aucun témoignage n’est sélectionné, les témoignages les plus récents seront affichés automatiquement.',

            'required' => 0,

            'post_type' => [
                'testimony',
            ],

            'post_status' => [
                'publish',
            ],

            'filters' => [
                'search',
            ],

            'return_format' => 'id',

            'min' => 0,

            'max' => 3,
        ],
    ],

    /*
     * ==========================================================
     * LOCATION
     * ==========================================================
     */
    'location' => [
        [
            [
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/lumina-testimonials',
            ],
        ],
    ],

    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
]);