<?php

namespace Webid\RecipientItemField;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;
use Webid\CmsNova\Modules\Form\Models\Form;
use Webid\CmsNova\Modules\Form\Models\Service;
use Webid\CmsNova\Modules\Form\Repositories\RecipientRepository;

class RecipientItemField extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'recipient-item-field';

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(string $name, ?string $attribute = null, callable $resolveCallback = null)
    {
        $recipientRepository = app()->make(RecipientRepository::class);

        $allField = $recipientRepository->all();
        $allField->map(function ($recipient) {
            return $recipient;
        });

        $this->withMeta(['items' => $allField]);

        parent::__construct($name, $attribute, $resolveCallback);
    }

    /**
     * @param string $requestAttribute
     * @param object $model
     * @param string $attribute
     */
    public function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        $recipientItems = $request[$requestAttribute];
        $recipientItems = collect(json_decode($recipientItems, true));

        $recipientItemIds = [];

        $recipientItems->each(function ($recipientItem, $key) use (&$recipientItemIds) {
            $recipientItemIds[] = $recipientItem['id'];
        });

        if (Form::class == get_class($model)) {
            Form::saved(function ($model) use ($recipientItemIds) {
                $model->recipients()->sync($recipientItemIds);
            });
        } elseif (Service::class == get_class($model)) {
            Service::saved(function ($model) use ($recipientItemIds) {
                $model->recipients()->sync($recipientItemIds);
            });
        }
    }

    /**
     * @param mixed $resource
     * @param null  $attribute
     */
    public function resolve($resource, $attribute = null)
    {
        parent::resolve($resource, $attribute);
        $resource->recipients();

        $valueInArray = [];
        $resource->recipients->each(function ($item) use (&$valueInArray) {
            $valueInArray[] = $item;
        });

        if ($valueInArray) {
            $this->value = $valueInArray;
        }
    }
}
