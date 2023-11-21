<?php

namespace Webid\ConfirmationEmailItemField;

use Laravel\Nova\Fields\Field;

class ConfirmationEmailItemField extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'confirmation-email-item-field';

    public function __construct(string $name, ?string $attribute = null, callable $resolveCallback = null)
    {
        $this->withMeta([
            'fieldTypeEmail' => array_search('email', config('fields_type')),
        ]);

        parent::__construct($name, $attribute, $resolveCallback);
    }
}
