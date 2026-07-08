<?php

namespace Lumina\ApiV2\Controllers;

use Lumina\ApiV2\Helpers\Response;
use Lumina\ApiV2\Services\FooterService;
use Lumina\ApiV2\Services\HeaderService;

class LayoutController
{
    public function header(\WP_REST_Request $request)
    {
        $lang = $request->get_param('lang');

        return Response::success(HeaderService::get($lang));
    }

    public function footer(\WP_REST_Request $request)
    {
        $lang = $request->get_param('lang');

        return Response::success(FooterService::get($lang));
    }
}
