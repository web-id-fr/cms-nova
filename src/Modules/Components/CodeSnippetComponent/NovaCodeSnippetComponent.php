<?php

namespace Webid\CmsNova\App\Nova\Components;

use Illuminate\Http\Request;
use InteractionDesignFoundation\HtmlCard\HtmlCard;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;
use Webid\CmsNova\App\Models\Components\CodeSnippetComponent as CodeSnippetComponentModel;
use Webid\CmsNova\Modules\JavaScript\Nova\CodeSnippet;

class NovaCodeSnippetComponent extends Resource
{
    /** @var CodeSnippetComponentModel */
    public $resource;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = CodeSnippetComponentModel::class;

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
        return __('Code snippets');
    }

    /**
     * @return string
     */
    public static function singularLabel()
    {
        return __('Code snippet');
    }

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make(__('Name'), 'name')
                ->rules('required'),

            BelongsTo::make(__('Code snippet'), 'codeSnippet', CodeSnippet::class)
                ->showCreateRelationButton()
                ->hideFromIndex(),

            Select::make(__('Status'), 'status')
                ->options(CodeSnippetComponentModel::statusLabels())
                ->displayUsingLabels()
                ->rules('required', 'integer')
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
