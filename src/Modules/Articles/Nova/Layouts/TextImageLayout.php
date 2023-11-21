<?php

namespace Webid\CmsNova\Modules\Articles\Nova\Layouts;

use Laravel\Nova\Fields\Select;
use Oneduo\NovaFileManager\FileManager;
use Webid\TranslatableItemField\Translatable;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class TextImageLayout extends Layout
{
    /**
     * The layout's unique identifier.
     *
     * @var string
     */
    protected $name = 'text-image';

    /**
     * @return null|array|string
     */
    public function title()
    {
        return __('Text & image section');
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

            FileManager::make(__('Image'), 'image'),

            Translatable::make(__('Balise alt'), 'balise_alt')
                ->singleLine(),
        ];
    }
}
