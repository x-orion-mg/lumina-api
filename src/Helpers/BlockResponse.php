<?php

namespace Lumina\ApiV2\Helpers;

class BlockResponse
{
    /**
     * Format standard d'un block dans la réponse API.
     */
    public static function make(string $type, array $data): array
    {
        return [
            'type' => $type,
            'data' => $data,
        ];
    }
}
