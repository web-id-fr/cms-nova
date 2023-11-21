<?php

namespace Webid\ComponentItemField\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Laravel\Nova\Http\Requests\NovaRequest;
use Webid\CmsNova\App\Http\Controllers\BaseController;

class PreviewItemFieldController extends BaseController
{
    public function storeTemplateData(NovaRequest $request): JsonResponse
    {
        $data = $request->all();
        $token = uniqid();

        session([$token => $data]);

        return response()->json([
            'token' => $token,
        ]);
    }
}
