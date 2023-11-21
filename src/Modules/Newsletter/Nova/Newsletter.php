<?php

namespace Webid\CmsNova\Modules\Newsletter\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Actions\ExportAsCsv;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;
use Webid\CmsNova\Modules\Newsletter\Models\Newsletter as NewsletterModel;

class Newsletter extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = NewsletterModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'email';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'email',
    ];

    /**
     * @return null|array|string
     */
    public static function label()
    {
        return __('Newsletters');
    }

    public function fields(Request $request): array
    {
        return [
            Text::make(__('Email'), 'email')
                ->sortable()
                ->rules('required', 'unique:newsletters,email,{{resourceId}}', 'email'),

            DateTime::make(__('Created At'), 'created_at')
                ->rules('required'),

            Text::make(__('Language'), 'lang')
                ->rules('required'),
        ];
    }

    public function actions(Request $request): array
    {
        return [
            ExportAsCsv::make(),
        ];
    }
}
