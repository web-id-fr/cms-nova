<?php

namespace Webid\CmsNova\Modules\Slideshow\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Resource;
use Oneduo\NovaFileManager\FileManager;
use Webid\AdvancedUrlField\AdvancedUrlField;
use Webid\CmsNova\Modules\Slideshow\Models\Slide as SlideModel;
use Webid\TranslatableItemField\Translatable;

class Slide extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = SlideModel::class;

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
        return __('Slides');
    }

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Translatable::make(__('Title'), 'title')
                ->singleLine()
                ->rules('required'),

            Translatable::make(__('Description'), 'description')
                ->trix()
                ->asHtml()
                ->hideFromIndex(),

            Translatable::make(__('CTA name'), 'cta_name')
                ->singleLine()
                ->rules('array')
                ->hideFromIndex(),

            AdvancedUrlField::make(__('CTA link'), 'cta_url')
                ->rules('array')
                ->hideFromIndex(),

            AdvancedUrlField::make(__('Url'), 'url')
                ->rules('array')
                ->hideFromIndex(),

            FileManager::make(__('Image'), 'image'),

            Translatable::make(__('Image balise alt'), 'image_alt')
                ->singleLine()
                ->hideFromIndex(),
        ];
    }
}
