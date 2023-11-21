<?php

namespace Webid\CmsNova\Modules\Slideshow\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Resource;
use Webid\CmsNova\Modules\Slideshow\Models\Slideshow as SlideshowModel;
use Webid\ImageItemField\ImageItemField;
use Webid\TranslatableItemField\Translatable;

class Slideshow extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = SlideshowModel::class;

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
        'title',
    ];

    /**
     * @return null|array|string
     */
    public static function label()
    {
        return __('Slideshows');
    }

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Translatable::make(__('Title'), 'title')
                ->singleLine()
                ->rules('required'),

            Boolean::make(__('Arrows display'), 'js_controls'),

            Boolean::make(__('Automatic slider'), 'js_animate_auto'),

            Number::make(__('Sliding speed'), 'js_speed')
                ->min(1)
                ->step(1)
                ->help(__('By default 5 seconds'))
                ->default(5)
                ->resolveUsing(function ($js_speed) {
                    if (empty($js_speed)) {
                        return '';
                    }

                    return $js_speed / 1000;
                })->displayUsing(function ($js_speed) {
                    return $js_speed / 1000;
                }),

            ImageItemField::make(__('Slides'), 'slides')
                ->onlyOnForms(),
        ];
    }
}
