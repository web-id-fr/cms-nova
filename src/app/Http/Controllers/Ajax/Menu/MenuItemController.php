<?php

namespace Webid\CmsNova\App\Http\Controllers\Ajax\Menu;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Webid\CmsNova\App\Http\Controllers\BaseController;
use Webid\CmsNova\App\Http\Resources\Menu\MenuItemResource;
use Webid\CmsNova\App\Repositories\Menu\MenuCustomItemRepository;
use Webid\CmsNova\App\Repositories\PageRepository;

class MenuItemController extends BaseController
{
    public function __construct(
        private MenuCustomItemRepository $menuCustomItemRepository,
        private PageRepository $templateRepository
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $allCustomItem = $this->menuCustomItemRepository->all();
        $allPage = $this->templateRepository->getPublishedPages();
        $allItem = $allCustomItem->merge($allPage);

        return response()->json(MenuItemResource::collection($allItem));
    }
}
