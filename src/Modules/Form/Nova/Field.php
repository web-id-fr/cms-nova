<?php

namespace Webid\CmsNova\Modules\Form\Nova;

use Alexwenzel\DependencyContainer\DependencyContainer;
use Alexwenzel\DependencyContainer\HasDependencies;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;
use Webid\CmsNova\Modules\Form\Models\Field as FieldModel;
use Webid\TranslatableItemField\Translatable;
use Whitecube\NovaFlexibleContent\Flexible;

class Field extends Resource
{
    use HasDependencies;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = FieldModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'field_name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'field_name',
    ];

    /**
     * @return null|array|string
     */
    public static function label()
    {
        return __('Fields');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     *
     * @throws \Exception
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Select::make(__('Field type'), 'field_type')
                ->options(config('fields_type'))
                ->rules('required')
                ->hideFromIndex(),

            Text::make(__('Field name'), 'field_name')
                ->help(__('Please use only this type of name "name-of-the-field"'))
                ->rules('required'),

            Translatable::make(__('Label'), 'label')
                ->singleLine(),

            DependencyContainer::make([
                Flexible::make(__('Field items'), 'field_options')
                    ->addLayout(__('Item section'), 'option', [
                        Translatable::make(__('Item'), 'item')
                            ->singleLine(),
                    ])->button(__('Add option')),
            ])->dependsOn('field_type', array_search('select', config('fields_type')))
                ->dependsOn('field_type', array_search('radio', config('fields_type'))),

            DependencyContainer::make([
                Translatable::make(__('Date field title'), 'date_field_title')
                    ->singleLine(),

                Translatable::make(__('Date field placeholder'), 'date_field_placeholder')
                    ->singleLine(),

                Text::make(__('Field name time'), 'field_name_time'),

                Translatable::make(__('Time field title'), 'time_field_title')
                    ->singleLine(),

                Translatable::make(__('Time field placeholder'), 'time_field_placeholder')
                    ->singleLine(),

                Text::make(__('Field name duration'), 'field_name_duration'),

                Translatable::make(__('Duration field title'), 'duration_field_title')
                    ->singleLine(),

                Flexible::make(__('Duration items'), 'field_options')
                    ->addLayout(__('Item section'), 'option', [
                        Translatable::make(__('Item'), 'item')
                            ->singleLine(),
                    ])->button(__('Add item')),
            ])->dependsOn('field_type', array_search('date-time', config('fields_type'))),

            DependencyContainer::make([
                Translatable::make(__('Placeholder'), 'placeholder')
                    ->singleLine(),
            ])->dependsOnNot('field_type', array_search('select', config('fields_type')))
                ->dependsOnNot('field_type', array_search('file', config('fields_type')))
                ->dependsOnNot('field_type', array_search('date-time', config('fields_type')))
                ->dependsOnNot('field_type', array_search('radio', config('fields_type'))),

            Boolean::make(__('Required'), 'required')
                ->withMeta([
                    'value' => data_get($this, 'required', false),
                ]),
        ];
    }
}
