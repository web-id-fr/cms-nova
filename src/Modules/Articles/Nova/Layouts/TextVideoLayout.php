<?php

namespace Webid\CmsNova\Modules\Articles\Nova\Layouts;

use Laravel\Nova\Fields\Select;
use Oneduo\NovaFileManager\FileManager;
use Webid\TranslatableItemField\Translatable;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class TextVideoLayout extends Layout
{
    /**
     * The layout's unique identifier.
     *
     * @var string
     */
    protected $name = 'text-video';

    /**
     * @return null|array|string
     */
    public function title()
    {
        return __('Text & video section');
    }

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Translatable::make(__('Text'), 'text')
                ->showRefresh()
                ->trix()
                ->asHtml(),

            Select::make(__('Text position'), 'text_position')
                ->options([
                    'left' => __('Left'),
                    'right' => __('Right'),
                ]),

            FileManager::make(__('Video'), 'video'),
        ];
    }
}
