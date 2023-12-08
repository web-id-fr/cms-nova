<?php

namespace Webid\PageUrlItemField;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Fields\Field;

class PageUrlItemField extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'page-url-item-field';

    /**
     * @param string               $name
     * @param null|callable|string $attribute
     */
    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $locales = array_map(function ($value) {
            return __($value);
        }, config('cms.locales'));

        $this->withMeta([
            'locales' => $locales,
            'indexLocale' => app()->getLocale(),
        ]);
    }

    public function url(array $urls): PageUrlItemField
    {
        return $this->withMeta([
            'urls' => $urls,
        ]);
    }
}
