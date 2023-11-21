<?php

namespace Webid\ComponentItemField\Http\Controllers;

use App\Services\ComponentsService;
use Illuminate\Http\JsonResponse;
use Laravel\Nova\Http\Requests\NovaRequest;
use Webid\CmsNova\App\Http\Controllers\BaseController;

class ComponentItemFieldController extends BaseController
{
    public function getChildComponentData(NovaRequest $request): JsonResponse
    {
        $componentService = app(ComponentsService::class);

        $allComponents = $componentService->getAllComponents();

        return response()->json([
            'items' => $allComponents,
        ]);
    }
}
