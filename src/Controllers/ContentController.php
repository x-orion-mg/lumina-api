<?php

namespace Lumina\ApiV2\Controllers;

use Lumina\ApiV2\Helpers\Response;
use Lumina\ApiV2\Services\ContentTypeService;
use Lumina\ApiV2\Services\PostContentService;

class ContentController
{
    public function types(\WP_REST_Request $request)
    {
        return Response::success([
            'items' => ContentTypeService::exposedTypes(),
            'total' => count(ContentTypeService::exposedTypes()),
        ]);
    }

    public function index(\WP_REST_Request $request)
    {
        $postType = (string) $request->get_param('post_type');
        $lang = (string) $request->get_param('lang');

        if (!ContentTypeService::isExposed($postType)) {
            return Response::error('Post type not allowed', 404);
        }

        return Response::success(PostContentService::list($postType, $lang, [
            'search'   => $request->get_param('search'),
            'page'     => $request->get_param('page'),
            'per_page' => $request->get_param('per_page'),
        ]));
    }

    public function show(\WP_REST_Request $request)
    {
        $postType = (string) $request->get_param('post_type');
        $slug = (string) $request->get_param('slug');
        $lang = (string) $request->get_param('lang');

        if (!ContentTypeService::isExposed($postType)) {
            return Response::error('Post type not allowed', 404);
        }

        $data = PostContentService::getBySlug($postType, $slug, $lang);

        if ($data === null) {
            return Response::error('Content not found', 404);
        }

        return Response::success($data);
    }
}
