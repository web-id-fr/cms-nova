<?php

namespace Webid\CmsNova\Modules\Articles\Nova\Layouts;

use Oneduo\NovaFileManager\FileManager;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class VideoLayout extends Layout
{
    /**
     * The layout's unique identifier.
     *
     * @var string
     */
    protected $name = 'video';

    /**
     * @return null|array|string
     */
    public function title()
    {
        return __('Video section');
    }

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            FileManager::make(__('Video'), 'video'),
        ];
    }
}
