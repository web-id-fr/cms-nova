<?php

namespace Webid\CmsNova\App\Repositories\Menu;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Webid\CmsNova\App\Models\Menu\Menu;

class MenuRepository
{
    public function __construct(private Menu $model)
    {
    }

    /**
     * @return Collection<Menu>
     */
    public function all()
    {
        return $this->model
            ->withZones()
            ->with(['items' => function ($query) {
                $query->with('menus.children')
                    ->whereHas('menus', function ($query) {
                        $query->whereNull('parent_id');
                    })
                ;
            }])
            ->get()
        ;
    }

    public function find(int $id): ?Menu
    {
        /** @var null|Menu $menu */
        $menu = $this->model
            ->find($id)
        ;

        if ($menu) {
            $menu->with(['items' => function ($query) {
                $query->whereHas('menus', function ($query) {
                    $query->whereNull('parent_id');
                });
            }]);
        }

        return $menu;
    }

    public function attachMenuToZone(int $menuID, string $zoneID): bool
    {
        if (empty($menuID) || empty($zoneID)) {
            return false;
        }

        return DB::table('menus_zones')
            ->updateOrInsert(
                ['zone_id' => $zoneID],
                ['menu_id' => $menuID]
            )
        ;
    }

    public function detachAllMenusFromZone(string $zoneID): bool
    {
        if (empty($zoneID)) {
            return false;
        }

        $deletedRows = DB::table('menus_zones')
            ->where('zone_id', $zoneID)
            ->delete()
        ;

        return $deletedRows > 0;
    }

    public function menuZoneExist(string $zoneID): bool
    {
        if (empty($zoneID)) {
            return false;
        }

        return DB::table('menus_zones')
            ->where('zone_id', $zoneID)
            ->exists();
    }
}
