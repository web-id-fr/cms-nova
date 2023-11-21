<?php

namespace Webid\CmsNova\App\Nova\Components;

use Illuminate\Http\Request;
use InteractionDesignFoundation\HtmlCard\HtmlCard;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;
use Webid\CmsNova\App\Models\Components\NewsletterComponent as NewsletterComponentModel;
use Webid\TranslatableItemField\Translatable;

class NewsletterComponent extends Resource
{
    /** @var NewsletterComponentModel */
    public $resource;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = NewsletterComponentModel::class;

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
     *
     * @return string
     */
    public static function label()
    {
        return __('Newsletters');
    }

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make(__('Name'), 'name')
                ->rules('required'),

            Translatable::make(__('Title'), 'title')
                ->singleLine()
                ->sortable(),

            Translatable::make(__('Placeholder'), 'placeholder')
                ->singleLine()
                ->sortable(),

            Translatable::make(__('CTA Name'), 'cta_name')
                ->singleLine()
                ->sortable(),

            Select::make(__('Status'), 'status')
                ->options(NewsletterComponentModel::statusLabels())
                ->displayUsingLabels()
                ->rules('integer')
                ->hideFromIndex(),

            Boolean::make(__('Published'), function () {
                return $this->resource->isPublished();
            })->onlyOnIndex(),
        ];
    }

    public function cards(Request $request): array
    {
        return [
            (new HtmlCard())->width('1/3')
                ->view('cards.component', ['model' => self::$model])
                ->center(true),
        ];
    }
}
