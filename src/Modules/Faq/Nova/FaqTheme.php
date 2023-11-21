<?php

namespace Webid\CmsNova\Modules\Faq\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Resource;
use Webid\CmsNova\Modules\Faq\Models\FaqTheme as FaqThemeModel;
use Webid\TranslatableItemField\Translatable;

class FaqTheme extends Resource
{
    /** @var FaqThemeModel */
    public $resource;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = FaqThemeModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'title',
    ];

    /**
     * @return null|array|string
     */
    public static function label()
    {
        return __('Faq Themes');
    }

    /**
     * @return null|array|string
     */
    public static function singularLabel()
    {
        return __('Faq Theme');
    }

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Translatable::make(__('Title'), 'title')
                ->rules('required')
                ->singleLine(),

            Select::make(__('Status'), 'status')
                ->options(FaqThemeModel::statusLabels())
                ->displayUsingLabels()
                ->rules('required', 'integer')
                ->sortable(),

            Boolean::make(__('Published'), function () {
                return $this->isPublished();
            })->onlyOnIndex(),
        ];
    }

    public function isPublished(): bool
    {
        return FaqThemeModel::_STATUS_PUBLISHED == $this->resource->status;
    }
}
