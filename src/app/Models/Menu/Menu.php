<?php

namespace Webid\CmsNova\App\Models\Menu;

use App\Models\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Translatable\HasTranslations;

/**
 * Class Menu.
 *
 * @property Collection $templates
 * @property Collection $menuCustomItems
 */
class Menu extends Model
{
    use HasFactory;
    use HasTranslations;

    /** Le séparateur utilisé dans la clause GROUP_BY du scope withZones() */
    protected const GROUP_BY_DELIMITER = '|||';

    public array $translatable = [
        'title',
    ];

    public Collection $menu_items;

    /** @var string */
    protected $table = 'menus';

    protected $fillable = [
        'title',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class)
            ->with('menus')
            ->orderBy('order')
        ;
    }

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->where('parent_type', Menu::class)
            ->with('menus')
            ->orderBy('order')
        ;
    }

    public function templates(): MorphToMany
    {
        return $this->morphedByMany(Page::class, 'menuable')
            ->withPivot('order', 'parent_id', 'parent_type')
            ->with('menus')
            ->orderBy('order')
        ;
    }

    public function menuCustomItems(): MorphToMany
    {
        return $this->morphedByMany(MenuCustomItem::class, 'menuable')
            ->withPivot('order', 'parent_id', 'parent_type')
            ->with('menus')
            ->orderBy('order')
        ;
    }

    public function chargeMenuItems(): void
    {
        $menuItems = collect();
        $templates = $this->templates;
        $customItems = $this->menuCustomItems;
        $children = [];

        $children = $this->getChildren($templates, $children);
        $children = $this->getChildren($customItems, $children);

        $menuItems = $this->mapItems($templates, $children, Page::class, $menuItems);
        $menuItems = $this->mapItems($customItems, $children, MenuCustomItem::class, $menuItems);

        $menuItems = $menuItems->sortBy(function ($item) {
            return $item->pivot->order;
        });

        $filteredItems = $menuItems->reject(function ($value, $key) {
            if (! empty($value->pivot->parent_id)) {
                return true;
            }

            return false;
        });

        $this->menu_items = $filteredItems;
    }

    public function getZonesAttribute(null|array|string $zones): array
    {
        if (! empty($zones) && is_string($zones)) {
            $zones = explode(static::GROUP_BY_DELIMITER, $zones);
        }

        if (! empty($zones) && is_array($zones)) {
            $zones = array_filter($zones);
        }

        if (! is_array($zones)) {
            return [];
        }

        return $zones;
    }

    public function scopeWithZones(Builder $query): Builder
    {
        $table = $this->getTable();

        return $query->select(
            "{$table}.*",
            DB::raw('menus_zones.zone_id as zones')
        )->leftJoin('menus_zones', "{$table}.id", '=', 'menus_zones.menu_id');
    }

    protected function mapItems(Collection $items, array $children, string $model, Collection $menuItems): Collection
    {
        $items->each(function ($item) use ($children, &$menuItems, $model) {
            if (
                ! empty($children)
                && array_key_exists($item->getOriginal('pivot_menu_id'), $children)
                && array_key_exists($item->id . '-' . $model, $children[$item->getOriginal('pivot_menu_id')])
            ) {
                $item->children = $children[$item->getOriginal('pivot_menu_id')][$item->id . '-' . $model];
            } else {
                $item->children = [];
            }
            $item->menuable_type = $model;
            $menuItems->push($item);
        });

        return $menuItems;
    }

    protected function getChildren(Collection $items, array $children): array
    {
        foreach ($items as $item) {
            foreach ($item->menus as $menu) {
                if (! empty($menu->pivot->parent_id)) {
                    $pivot = $menu->pivot;
                    $children[$pivot->menu_id][$pivot->parent_id . '-' . $pivot->parent_type][] = $item;
                }
            }
        }

        return $children;
    }
}
