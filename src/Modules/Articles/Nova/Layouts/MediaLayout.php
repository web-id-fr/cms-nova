<?php

namespace Webid\CmsNova\Modules\Articles\Nova\Layouts;

use Oneduo\NovaFileManager\FileManager;
use Webid\TranslatableItemField\Translatable;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class MediaLayout extends Layout
{
    /**
     * The layout's unique identifier.
     *
     * @var string
     */
    protected $name = 'media';

    /**
     * @return null|array|string
     */
    public function title()
    {
        return __('Button media section');
    }

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Translatable::make(__('CTA Name'), 'cta_name')
                ->singleLine(),

            FileManager::make(__('Media'), 'media'),
        ];
    }
}
