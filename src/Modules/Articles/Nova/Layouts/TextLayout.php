<?php

namespace Webid\CmsNova\Modules\Articles\Nova\Layouts;

use Webid\TranslatableItemField\Translatable;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class TextLayout extends Layout
{
    /**
     * The layout's unique identifier.
     *
     * @var string
     */
    protected $name = 'text';

    /**
     * @return null|array|string
     */
    public function title()
    {
        return __('Text section');
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
        ];
    }
}
