<?php

namespace Webid\CmsNova\Modules\Articles\Nova\Layouts;

use Oneduo\NovaFileManager\FileManager;
use Webid\TranslatableItemField\Translatable;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class ImageLayout extends Layout
{
    /**
     * The layout's unique identifier.
     *
     * @var string
     */
    protected $name = 'image';

    /**
     * @return null|array|string
     */
    public function title()
    {
        return __('Image section');
    }

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            FileManager::make(__('Image'), 'image'),

            Translatable::make(__('Balise alt'), 'balise_alt')
                ->singleLine(),
        ];
    }
}
