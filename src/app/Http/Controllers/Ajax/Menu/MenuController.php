<?php

namespace Webid\CmsNova\App\Http\Controllers\Ajax\Menu;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Webid\CmsNova\App\Http\Controllers\BaseController;
use Webid\CmsNova\App\Http\Resources\Menu\MenuResource;
use Webid\CmsNova\App\Repositories\Menu\MenuRepository;

class MenuController extends BaseController
{
    public function __construct(private MenuRepository $menuRepository)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        return MenuResource::collection($this->menuRepository->all());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(MenuResource::make($this->menuRepository->find($id)));
    }
}
