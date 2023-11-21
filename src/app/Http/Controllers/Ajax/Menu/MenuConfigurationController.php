<?php

namespace Webid\CmsNova\App\Http\Controllers\Ajax\Menu;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Webid\CmsNova\App\Http\Controllers\BaseController;
use Webid\CmsNova\App\Http\Resources\Menu\MenuZoneResource;
use Webid\CmsNova\App\Repositories\Menu\MenuRepository;
use Webid\CmsNova\App\Services\MenuService;

class MenuConfigurationController extends BaseController
{
    public function __construct(private MenuRepository $menuRepository)
    {
    }

    public function index(): JsonResponse
    {
        try {
            $menus = MenuZoneResource::collection(MenuService::make()->getMenusZones());

            $menus = data_get($menus, 'data', $menus);
        } catch (\Throwable $exception) {
            $menus = [];
        }

        return response()->json($menus);
    }

    public function updateZone(Request $request): JsonResponse
    {
        $menu_id = (int) $request->get('menu_id', 0);
        $zone_id = (string) $request->get('zone_id', '');

        if (empty($menu_id)) {
            $success = $this->menuRepository->detachAllMenusFromZone($zone_id);
            $message = "The menus attached to zone {$zone_id} had been successfully removed.";
        } else {
            $success = $this->menuRepository->attachMenuToZone($menu_id, $zone_id);
            $message = "The menu #{$menu_id} had been successfully assigned to zone {$zone_id}.";
        }

        if ($success) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        }

        return response()->json([
            'success' => false,
        ], 400);
    }
}
