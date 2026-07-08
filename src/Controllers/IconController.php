<?php

namespace Lumina\ApiV2\Controllers;

use Lumina\ApiV2\Helpers\Response;
use Lumina\ApiV2\Services\IconService;

class IconController
{
    public function index(\WP_REST_Request $request)
    {
        $search = $request->get_param('search');

        return Response::success(IconService::list(is_string($search) ? $search : null));
    }

    public function show(\WP_REST_Request $request)
    {
        $slug = (string) $request->get_param('slug');
        $icon = IconService::getBySlug($slug);

        if ($icon === null) {
            return Response::error('Icon not found', 404);
        }

        return Response::success($icon);
    }
}
