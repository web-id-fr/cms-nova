<?php

namespace Webid\CmsNova\Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Webid\CmsNova\App\Models\Menu\Menu;
use Webid\CmsNova\App\Models\Menu\MenuCustomItem;

class MenuItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'menu_id' => null,
            'menuable_id' => null,
            'menuable_type' => null,
            'order' => random_int(1, 999),
            'parent_id' => null,
            'parent_type' => null,
        ];
    }

    public function hasItem(MenuCustomItem|Page $menuable): self
    {
        return $this->state(function () use ($menuable) {
            return [
                'menuable_id' => $menuable->getKey(),
                'menuable_type' => get_class($menuable),
            ];
        });
    }

    public function hasParent(MenuCustomItem|Page $parent): self
    {
        return $this->state(function () use ($parent) {
            return [
                'parent_id' => $parent->getKey(),
                'parent_type' => get_class($parent),
            ];
        });
    }

    public function forMenu(Menu $menu): self
    {
        return $this->state(function () use ($menu) {
            return [
                'menu_id' => $menu->getKey(),
            ];
        });
    }
}
