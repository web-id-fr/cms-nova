<?php

namespace Webid\CmsNova\Modules\Form\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Resource;
use Webid\CmsNova\Modules\Form\Models\Service as ServiceModel;
use Webid\RecipientItemField\RecipientItemField;
use Webid\TranslatableItemField\Translatable;

class Service extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = ServiceModel::class;

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
        return __('Services');
    }

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Translatable::make(__('Name'), 'name')
                ->singleLine()
                ->rules('array', 'required'),

            RecipientItemField::make(__('Recipients'), 'recipients')
                ->onlyOnForms(),
        ];
    }
}
