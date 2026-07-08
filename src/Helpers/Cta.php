<?php

namespace Lumina\ApiV2\Helpers;

use Lumina\ApiV2\Services\HubSpotFormService;

/**
 * Bouton d’action : lien classique (Button) ou formulaire HubSpot (CPT contact-form).
 *
 * À appeler depuis les Transformers de blocks qui en ont besoin.
 */
class Cta
{
    /**
     * @param array<string, mixed> $data Ligne block ou champs ACF extraits.
     * @param array<string, mixed> $options
     *   - mode_field (default: is_contact_form)
     *   - contact_form_values (valeurs = mode HubSpot)
     *   - label_field (default: label_button)
     *   - link_field (default: button)
     *   - form_field (default: contact_form)
     */
    public static function parse(array $data, array $options = []): ?array
    {
        $options = array_merge([
            'mode_field'          => 'is_contact_form',
            'contact_form_values' => ['contact_form', '1', 1, true, 'yes'],
            'label_field'         => 'label_button',
            'link_field'          => 'button',
            'form_field'          => 'contact_form',
        ], $options);

        if (self::isContactFormMode($data, $options)) {
            return self::parseContactForm($data, $options);
        }

        $linkKey = (string) $options['link_field'];
        $link = $data[$linkKey] ?? null;

        if ($link === null || $link === '' || $link === []) {
            return null;
        }

        return Button::parse($link);
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, mixed> $options
     */
    private static function isContactFormMode(array $data, array $options): bool
    {
        $modeField = (string) $options['mode_field'];

        if ($modeField === '' || !array_key_exists($modeField, $data)) {
            return false;
        }

        $mode = $data[$modeField];
        $allowed = $options['contact_form_values'];

        if (is_bool($mode)) {
            return $mode;
        }

        if (is_numeric($mode)) {
            return (int) $mode === 1;
        }

        return in_array($mode, $allowed, true);
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, mixed> $options
     */
    private static function parseContactForm(array $data, array $options): ?array
    {
        $label = (string) ($data[(string) $options['label_field']] ?? '');
        $formField = (string) $options['form_field'];
        $form = HubSpotFormService::resolve($data[$formField] ?? null, $label);

        if ($form === null) {
            return null;
        }

        return [
            'type'          => 'hubspot_form',
            'label'         => $label !== '' ? $label : ($form['label'] ?? $form['title'] ?? ''),
            'hubspot'       => true,
            'contact_form'  => $form,
            'is_contact_form' => true,
            'hubSpot'       => $form['hubspot'],
        ];
    }
}
