<?php

namespace Webid\AdvancedUrlField;

use Laravel\Nova\Fields\Field;

class AdvancedUrlField extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'advanced-url-field';

    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $locales = array_map(function ($value) {
            return __($value);
        }, config('cms.locales'));

        $this->withMeta([
            'locales' => $locales,
        ]);
    }
}
