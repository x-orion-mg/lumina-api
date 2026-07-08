<?php

namespace Lumina\ApiV2\Acf;

/**
 * Définitions ACF réutilisables pour un bouton (lien ou formulaire HubSpot).
 * À fusionner dans les sub_fields d’un block via array_merge.
 */
class ButtonFields
{
    /**
     * @param string $prefix Préfixe des clés ACF (ex. "primary_" → primary_is_contact_form).
     * @return array<int, array<string, mixed>>
     */
    public static function group(string $prefix = '', string $label = 'Bouton'): array
    {
        $p = $prefix;
        $modeKey = $p . 'is_contact_form';
        $labelKey = $p . 'label_button';
        $formKey = $p . 'contact_form';
        $linkKey = $p . 'button';

        return [
            [
                'key' => 'field_' . $p . 'btn_mode',
                'label' => $label . ' — type',
                'name' => $modeKey,
                'type' => 'select',
                'choices' => [
                    'lien'          => 'Lien / page',
                    'contact_form'  => 'Formulaire HubSpot',
                ],
                'default_value' => 'lien',
                'ui' => 1,
                'return_format' => 'value',
            ],
            [
                'key' => 'field_' . $p . 'btn_link',
                'label' => $label,
                'name' => $linkKey,
                'type' => 'link',
                'return_format' => 'array',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_' . $p . 'btn_mode',
                            'operator' => '==',
                            'value' => 'lien',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'field_' . $p . 'btn_label',
                'label' => $label . ' — libellé',
                'name' => $labelKey,
                'type' => 'text',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_' . $p . 'btn_mode',
                            'operator' => '==',
                            'value' => 'contact_form',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'field_' . $p . 'btn_form',
                'label' => $label . ' — formulaire',
                'name' => $formKey,
                'type' => 'relationship',
                'post_type' => ['contact-form'],
                'filters' => ['search'],
                'max' => 1,
                'return_format' => 'id',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_' . $p . 'btn_mode',
                            'operator' => '==',
                            'value' => 'contact_form',
                        ],
                    ],
                ],
            ],
        ];
    }
}
