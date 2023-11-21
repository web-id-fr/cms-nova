<?php

namespace Webid\CmsNova\App\Models\Contracts;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;

interface Menuable
{
    public function menus(): MorphToMany;

    public function children(): HasMany;

    public function childrenForMenu(int $menu_id): Collection;
}
