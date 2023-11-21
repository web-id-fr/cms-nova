<?php

namespace Webid\TranslatableItemField;

use Laravel\Nova\Fields\Field;

class Translatable extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'translatable';

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

    public function locales(array $locales): self
    {
        return $this->withMeta(['locales' => $locales]);
    }

    public function indexLocale(string $locale): self
    {
        return $this->withMeta(['indexLocale' => $locale]);
    }

    public function singleLine(): self
    {
        return $this->withMeta(['singleLine' => true]);
    }

    public function trix(): self
    {
        return $this->withMeta(['trix' => true]);
    }

    public function asHtml(): self
    {
        return $this->withMeta(['asHtml' => true]);
    }

    public function truncate(): self
    {
        return $this->withMeta(['truncate' => true]);
    }

    public function shortenText(): self
    {
        return $this->withMeta(['shortenText' => true]);
    }

    public function showRefresh(): self
    {
        return $this->withMeta(['showRefresh' => true]);
    }

    public function defaultValues(array $values): self
    {
        return $this->withMeta(['defaultValues' => $values]);
    }

    /**
     * Resolve the given attribute from the given resource.
     *
     * @param mixed  $resource
     * @param string $attribute
     *
     * @return mixed
     */
    protected function resolveAttribute($resource, $attribute)
    {
        if (method_exists((object) $resource, 'getTranslations')) {
            return $resource->getTranslations($attribute);
        }

        return data_get($resource, $attribute);
    }
}
