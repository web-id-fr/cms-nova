<?php

namespace Webid\CmsNova\Modules\Components\TextComponent\Nova;

use Illuminate\Http\Request;
use InteractionDesignFoundation\HtmlCard\HtmlCard;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;
use Webid\CmsNova\Modules\Components\TextComponent\Models\TextComponent as ComponentModel;

class TextNovaComponent extends Resource
{
    /** @var ComponentModel */
    public $resource;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = ComponentModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
    ];

    /**
     * Get the displayable label of the resource.
     */
    public static function label(): string
    {
        return __('Text');
    }

    /**
     * Get the displayable singular label of the resource.
     */
    public static function singularLabel(): string
    {
        return __('Text');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make(__('Name'), 'name')
                ->rules('required'),

            Text::make(__('Text'), 'text')
                ->rules('required')
                ->hideFromIndex(),

            Select::make(__('Status'), 'status')
                ->options(ComponentModel::statusLabels())
                ->displayUsingLabels()
                ->rules(['integer', 'required'])
                ->hideFromIndex(),

            Boolean::make(__('Published'), function () {
                return $this->resource->isPublished();
            })->onlyOnIndex(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [
            (new HtmlCard())->width('1/3')
                ->view('cards.component', ['model' => self::$model])
                ->center(true),
        ];
    }
}
