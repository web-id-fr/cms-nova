<?php

namespace Webid\CmsNova\App\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;
use Webid\CmsNova\App\Models\Menu\Menu;
use Webid\CmsNova\App\Models\Menu\MenuItem;

/**
 * Trait HasMenus.
 *
 * @property Collection $menus
 * @property Collection $children
 */
trait HasMenus
{
    public function menus(): MorphToMany
    {
        return $this->morphToMany(Menu::class, 'menuable')
            ->with('children')
            ->withPivot('order', 'parent_id', 'parent_type')
        ;
    }

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->where('parent_type', static::class)
            ->with('menus')
            ->orderBy('order')
        ;
    }

    public function childrenForMenu(int $menu_id): Collection
    {
        return $this->children->filter(function ($item) use ($menu_id) {
            return $item->menu_id == $menu_id;
        });
    }
}
