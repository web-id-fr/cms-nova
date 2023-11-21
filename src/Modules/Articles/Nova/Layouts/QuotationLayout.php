<?php

namespace Webid\CmsNova\Modules\Articles\Nova\Layouts;

use Webid\TranslatableItemField\Translatable;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class QuotationLayout extends Layout
{
    /**
     * The layout's unique identifier.
     *
     * @var string
     */
    protected $name = 'quotation';

    /**
     * @return null|array|string
     */
    public function title()
    {
        return __('Quotation section');
    }

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Translatable::make(__('Quotation'), 'quotation')
                ->showRefresh()
                ->trix()
                ->asHtml(),
        ];
    }
}
