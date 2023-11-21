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
        }, config('translatable.locales'));

        $this->withMeta([
            'locales' => $locales,
            'indexLocale' => app()->getLocale(),
        ]);
    }

    public function locales(array $locales): PageUrlItemField
    {
        return $this->withMeta([
            'locales' => $locales,
        ]);
    }

    public function indexLocale(string $locale): PageUrlItemField
    {
        return $this->withMeta([
            'indexLocale' => $locale,
        ]);
    }

    public function urls(array $urls): PageUrlItemField
    {
        return $this->withMeta([
            'urls' => $urls,
        ]);
    }

    /**
     * Resolve the given attribute from the given resource.
     *
     * @param Model  $resource
     * @param string $attribute
     *
     * @return mixed
     */
    protected function resolveAttribute($resource, $attribute)
    {
        if (method_exists($resource, 'getTranslations')) {
            return $resource->getTranslations($attribute);
        }

        return data_get($resource, $attribute);
    }
}
