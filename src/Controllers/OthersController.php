<?php

namespace Lumina\ApiV2\Controllers;

use Lumina\ApiV2\Helpers\Response;
use Lumina\ApiV2\Services\OthersService;

class OthersController
{
    public function index(\WP_REST_Request $request)
    {
        $lang = $request->get_param('lang');
        $type = $request->get_param('type');

        return Response::success(OthersService::get($lang, $type));
    }
}
