<?php

namespace Webid\CmsNova\Modules\JavaScript\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;
use Webid\CmsNova\Modules\JavaScript\Models\CodeSnippet as CodeSnippetModel;

class CodeSnippet extends Resource
{
    /** @var CodeSnippetModel */
    public $resource;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = CodeSnippetModel::class;

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
        'id',
        'name',
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make(__('Name'), 'name')
                ->rules('required'),

            Code::make(__('Code Snippet'), 'source_code')
                ->language('javascript')
                ->hideFromIndex(),
        ];
    }
}
