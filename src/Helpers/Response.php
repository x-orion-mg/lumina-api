<?php


namespace Lumina\ApiV2\Helpers;

class Response
{
    public static function success($data)
    {
        return [
            'success' => true,
            'data' => $data
        ];
    }

    public static function error($message, $code = 400)
    {
        return new \WP_Error('error', $message, [
            'status' => $code
        ]);
    }
}