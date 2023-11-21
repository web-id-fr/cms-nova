<?php

namespace Webid\CmsNova\Modules\Redirections301\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;
use Webid\CmsNova\Modules\Redirections301\Models\Redirection as RedirectionModel;
use Webid\CmsNova\Modules\Redirections301\Rules\RedirectionRules;

class Redirection extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = RedirectionModel::class;

    public function fields(Request $request): array
    {
        return [
            Text::make(__('Source'), 'source_url')
                ->placeholder(__('/my-source-url'))
                ->help(__('Accepts only paths, no complete URL. Must start with a / .'))
                ->rules(RedirectionRules::sourceUrlRules($this->model()->getKey())),

            Text::make(__('Destination'), 'destination_url')
                ->placeholder(__('/my-destination-url'))
                ->help(__('Accepts only paths, no complete URL. Must start with a / .'))
                ->rules(RedirectionRules::destinationUrlRules()),
        ];
    }
}
