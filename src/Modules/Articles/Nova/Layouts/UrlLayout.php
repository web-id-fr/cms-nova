<?php

namespace Webid\CmsNova\Modules\Articles\Nova\Layouts;

use Webid\AdvancedUrlField\AdvancedUrlField;
use Webid\TranslatableItemField\Translatable;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class UrlLayout extends Layout
{
    /**
     * The layout's unique identifier.
     *
     * @var string
     */
    protected $name = 'url';

    /**
     * @return null|array|string
     */
    public function title()
    {
        return __('Button url section');
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

            AdvancedUrlField::make(__('CTA link'), 'url'),
        ];
    }
}
