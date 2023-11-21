<?php

namespace Webid\CmsNova\App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Webid\CmsNova\App\Models\Contracts\Menuable;

/**
 * Class MenuItem.
 *
 * @property string   $menuable_type
 * @property int      $menu_id
 * @property Menuable $menuable
 */
class MenuItem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menuables';

    public function menus(): MorphTo
    {
        return $this->morphTo('menuable');
    }
}
