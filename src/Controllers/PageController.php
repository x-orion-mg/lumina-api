<?php


namespace Lumina\ApiV2\Controllers;

use Lumina\ApiV2\Services\PageService;
use Lumina\ApiV2\Helpers\Response;

class PageController
{
    public function show(\WP_REST_Request $request)
    {
        $lang = $request->get_param('lang');
        $slug = $request->get_param('slug');

        $data = PageService::getBySlug($slug, $lang);

        if (!$data) {
            return Response::error('Page not found', 404);
        }

        return Response::success($data);
    }
}