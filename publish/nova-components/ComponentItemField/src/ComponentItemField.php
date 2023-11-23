<?php

namespace Webid\ComponentItemField;

use App\Models\Page;
use App\Services\ComponentsService;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;
use Webid\CmsNova\App\Models\Components\BreadcrumbComponent;

class ComponentItemField extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'component-item-field';

    public function __construct(string $name, ?string $attribute = null, callable $resolveCallback = null)
    {
        $componentsService = app(ComponentsService::class);
        $componentsConfig = config('components');
        $componentInfos = [];

        foreach ($componentsConfig as $componentConfig) {
            $componentInfos[$componentConfig['title']]['image'] = asset($componentConfig['image']);
            $componentInfos[$componentConfig['title']]['display_on_components_list'] = ! array_key_exists('display_on_components_list', $componentConfig);
        }

        $this->withMeta([
            'items' => $componentsService->getAllComponents(),
            'nova' => config('nova.path'),
            'componentInfos' => $componentInfos,
        ]);

        parent::__construct($name, $attribute, $resolveCallback);
    }

    /**
     * @param string $requestAttribute
     * @param object $model
     * @param string $attribute
     */
    public function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        $components = $request[$requestAttribute];
        $components = collect(json_decode($components, true));

        $breadcrumbComponentIds = [];

        foreach ($components as $key => $component) {
            switch ($component['component_type']) {
                case BreadcrumbComponent::class:
                    $breadcrumbComponentIds[$component['id']] = ['order' => (int) $key + 1];

                    break;
            }
        }

        Page::saved(function ($model) use (
            $breadcrumbComponentIds
        ) {
            // @var Template $model
            $model->breadcrumbComponents()->sync($breadcrumbComponentIds);
        });
    }

    /**
     * @param mixed $resource
     * @param null  $attribute
     */
    public function resolve($resource, $attribute = null)
    {
        parent::resolve($resource, $attribute);
        $resource->chargeComponents();

        $valueInArray = [];
        $resource->component_items->each(function ($item) use (&$valueInArray) {
            $valueInArray[] = $item;
        });

        if ($valueInArray) {
            $this->value = $valueInArray;
        }
    }
}
