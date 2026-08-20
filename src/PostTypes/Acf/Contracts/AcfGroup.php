<?php

namespace Lumina\ApiV2\PostTypes\Acf\Contracts;

interface AcfGroup
{
    /**
     * Identifiant ACF stable du groupe.
     */
    public static function key(): string;

    /**
     * Titre du groupe dans l'administration.
     */
    public static function title(): string;

    /**
     * Champs ACF du groupe.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function fields(): array;

    /**
     * Location ACF explicite.
     *
     * Si null, les locations sont générées automatiquement
     * à partir des Post Types qui utilisent le groupe.
     *
     * @return array<int, array<int, array<string, mixed>>>|null
     */
    public static function location(): ?array;
}