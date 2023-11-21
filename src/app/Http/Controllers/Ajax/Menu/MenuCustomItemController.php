<?php

namespace Webid\CmsNova\App\Http\Controllers\Ajax\Menu;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Webid\CmsNova\App\Http\Controllers\BaseController;
use Webid\CmsNova\App\Http\Resources\Menu\MenuCustomItemResource;
use Webid\CmsNova\App\Repositories\Menu\MenuCustomItemRepository;

class MenuCustomItemController extends BaseController
{
    public function __construct(private MenuCustomItemRepository $menuCustomItemRepository)
    {
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json(MenuCustomItemResource::collection($this->menuCustomItemRepository->all()));
    }
}
