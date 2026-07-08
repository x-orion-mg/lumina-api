<?php

acf_add_local_field_group([
    'key'    => 'group_be_faq_section',
    'title'  => 'Block - FAQ Section',
    'fields' => [
        [
            'key'           => 'field_be_faq_section_badge',
            'label'         => 'Badge',
            'name'          => 'badge',
            'type'          => 'text',
            'default_value' => 'FAQ',
        ],
        [
            'key'           => 'field_be_faq_section_title',
            'label'         => 'Titre',
            'name'          => 'title',
            'type'          => 'textarea',
            'instructions'  => 'Pour appliquer un effet de dégradé (gradient) à un texte, encadrez le mot ou l\'expression avec des crochets : [votre mot].',
            'rows'          => 3,
            'new_lines'     => 'br',
        ],
        [
            'key'           => 'field_be_faq_section_items',
            'label'         => 'Questions',
            'name'          => 'items',
            'type'          => 'repeater',
            'layout'        => 'block',
            'button_label'  => 'Ajouter une question',
            'min'           => 1,
            'sub_fields'    => [
                [
                    'key'   => 'field_be_faq_section_item_question',
                    'label' => 'Question',
                    'name'  => 'question',
                    'type'  => 'text',
                ],
                [
                    'key'           => 'field_be_faq_section_item_answer',
                    'label'         => 'Réponse',
                    'name'          => 'answer',
                    'type'          => 'wysiwyg',
                    'tabs'          => 'all',
                    'toolbar'       => 'basic',
                    'media_upload'  => 0,
                ],
            ],
        ],
    ],
    'location' => [[[
        'param'    => 'block',
        'operator' => '==',
        'value'    => 'acf/be-faq-section',
    ]]],
    'active' => true,
]);