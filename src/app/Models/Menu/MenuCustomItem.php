<?php

namespace Webid\CmsNova\App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webid\CmsNova\App\Models\Contracts\Menuable;
use Webid\CmsNova\App\Models\Traits\HasMenus;

/**
 * Class MenuCustomItem.
 *
 * @property int         $id
 * @property string      $title
 * @property int         $type_link
 * @property null|Form   $form
 * @property null|string $url
 * @property string      $target
 * @property string      $slug
 */
class MenuCustomItem extends Model implements Menuable
{
    use HasFactory;
    use HasMenus;

    public const _STATUS_SELF = '_SELF';
    public const _STATUS_BLANK = '_BLANK';
    public const _LINK_URL = 1;
    public const _LINK_FORM = 2;

    public array $translatable = [
        'title',
        'url',
        'menu_description',
    ];

    /** @var string */
    protected $table = 'menu_custom_items';

    protected $fillable = [
        'title',
        'url',
        'target',
        'type_link',
        'form_id',
        'menu_description',
    ];

    public static function statusTypes(): array
    {
        return [
            self::_STATUS_SELF => __('Same window'),
            self::_STATUS_BLANK => __('New window'),
        ];
    }

    public static function linksTypes(): array
    {
        return [
            self::_LINK_URL => __('Link url'),
            self::_LINK_FORM => __('Link form'),
        ];
    }

}
