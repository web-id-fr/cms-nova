<?php

namespace Webid\CmsNova\App\Http\Controllers\Ajax\Menu;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Webid\CmsNova\App\Http\Controllers\BaseController;
use Webid\CmsNova\App\Http\Resources\Menu\MenuItemResource;
use Webid\CmsNova\App\Repositories\Menu\MenuCustomItemRepository;
use Webid\CmsNova\App\Repositories\TemplateRepository;

class MenuItemController extends BaseController
{
    public function __construct(
        private MenuCustomItemRepository $menuCustomItemRepository,
        private TemplateRepository $templateRepository
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $allCustomItem = $this->menuCustomItemRepository->all();
        $allPage = $this->templateRepository->getPublishedTemplates();
        $allItem = $allCustomItem->merge($allPage);

        return response()->json(MenuItemResource::collection($allItem));
    }
}
