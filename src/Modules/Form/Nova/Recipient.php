<?php

namespace Webid\CmsNova\Modules\Form\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;
use Webid\CmsNova\Modules\Form\Models\Recipient as RecipientModel;

class Recipient extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = RecipientModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * @return null|array|string
     */
    public static function label()
    {
        return __('Recipients');
    }

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make(__('Name'), 'name')
                ->rules('required'),

            Text::make(__('Email'), 'email')
                ->rules('required', 'email'),
        ];
    }
}
