<?php

namespace Lumina\ApiV2\PostTypes\Acf;

abstract class AcfGroup
{
    /**
     * Identifiant ACF stable.
     */
    abstract public static function key(): string;

    /**
     * Titre du groupe ACF.
     */
    abstract public static function title(): string;

    /**
     * Champs ACF.
     *
     * @return array<int, array<string, mixed>>
     */
    abstract public static function fields(): array;

    /**
     * Location explicite.
     *
     * Retourner null pour laisser AcfRegistry
     * construire automatiquement les locations.
     *
     * @return array<int, array<int, array<string, mixed>>>|null
     */
    public static function location(): ?array
    {
        return null;
    }

    /**
     * Configuration supplémentaire du groupe ACF.
     *
     * @return array<string, mixed>
     */
    public static function config(): array
    {
        return [
            'menu_order'            => 0,
            'position'              => 'normal',
            'style'                 => 'default',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen'        => '',
            'active'                => true,
            'description'           => '',
            'show_in_rest'          => 0,
            'display_title'         => '',
            'show_in_graphql' => true,
            'map_graphql_types_from_location_rules' => 0,
            'graphql_field_name' => static::key(),
        ];
    }
}