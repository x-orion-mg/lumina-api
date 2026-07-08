<?php

namespace Lumina\ApiV2\Helpers;

class AcfRepeater
{
    /**
     * Transforme les lignes d'un repeater ACF pour l'API.
     *
     * @param mixed $rows Valeur retournée par get_field('mon_repeater') ou équivalent.
     * @param callable|null $mapper function(array $row, int $index, array $sourceData): array|null
     */
    public static function parse($rows, ?callable $mapper = null, array $sourceData = []): array
    {
        if (!is_array($rows) || $rows === []) {
            return [];
        }

        $out = [];

        foreach ($rows as $index => $row) {
            if (!is_array($row)) {
                continue;
            }

            $clean = self::stripInternalKeys($row);

            if ($mapper !== null) {
                $mapped = $mapper($clean, (int) $index, $sourceData);

                if ($mapped !== null) {
                    $out[] = $mapped;
                }

                continue;
            }

            $out[] = $clean;
        }

        return $out;
    }

    /**
     * Repeater ACF dans les attributs d'un block Gutenberg.
     *
     * Deux formats possibles :
     * - Tableau de lignes : $data['stats'] = [ ['value' => '…', 'label' => '…'], … ]
     * - Format aplati : $data['stats'] = (int) nombre de lignes + clés stats_0_value, stats_0_label, …
     *
     * @param array<string, mixed> $data Données du block (ex. AcfBlockData::extract).
     * @param string $name Nom du champ repeater (ex. 'stats').
     * @param string[] $subKeys Noms des sous-champs (ordre pour le format aplati), ex. ['value', 'label'].
     * @param callable|null $mapper function(array $row, int $index, array $sourceData): array|null
     */
    public static function parseFromBlockData(array $data, string $name, array $subKeys = [], ?callable $mapper = null): array
    {
        return self::parseFromBlockDataPrefixed($data, '', $name, $subKeys, $mapper);
    }

    /**
     * Repeater imbriqué (ex. tabs_0_features dans les attributs du block).
     *
     * @param string $prefix Préfixe des clés (ex. "tabs_0_").
     * @param callable|null $mapper function(array $row, int $index, array $sourceData): array|null
     */
    public static function parseFromBlockDataPrefixed(
        array $data,
        string $prefix,
        string $name,
        array $subKeys = [],
        ?callable $mapper = null
    ): array {
        $fullKey = $prefix . $name;

        if (!array_key_exists($fullKey, $data)) {
            return [];
        }

        $raw = $data[$fullKey];

        if (is_array($raw)) {
            return self::parse($raw, $mapper, $data);
        }

        if ($subKeys === []) {
            return [];
        }

        $count = (int) $raw;
        $rows = [];

        for ($i = 0; $i < $count; $i++) {
            $row = [];

            foreach ($subKeys as $key) {
                $row[$key] = self::readFlatValue($data, "{$prefix}{$name}_{$i}_{$key}");
            }

            $rows[] = $row;
        }

        return self::parse($rows, $mapper, $data);
    }

    /**
     * @param array<string, mixed> $data
     * @return mixed
     */
    private static function readFlatValue(array $data, string $baseKey)
    {
        $value = $data[$baseKey] ?? '';

        if ($value !== '' && $value !== []) {
            return $value;
        }

        if (isset($data["{$baseKey}_url"])) {
            return [
                'url'    => $data["{$baseKey}_url"] ?? '',
                'title'  => $data["{$baseKey}_title"] ?? '',
                'target' => $data["{$baseKey}_target"] ?? '',
            ];
        }

        return $value;
    }

    /**
     * Retire les clés internes ACF (préfixe _).
     */
    public static function stripInternalKeys(array $row): array
    {
        return array_filter(
            $row,
            static function ($key): bool {
                if (!is_string($key) || $key === '') {
                    return true;
                }

                return $key[0] !== '_';
            },
            ARRAY_FILTER_USE_KEY
        );
    }
}
