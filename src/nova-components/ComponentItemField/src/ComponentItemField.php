<?php

namespace Webid\ComponentItemField;

use App\Models\Page;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;
use Webid\CmsNova\App\Services\ComponentsService;
use Webid\CmsNova\Modules\Components\TextComponent\Models\TextComponent;
use Webid\CmsTextImageComponent\Models\TextImageComponent;

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

        foreach ($componentsConfig as $componentKey => $componentConfig) {
            $componentInfos[] = [
                'key' => $componentKey,
                'image' => asset($componentConfig['image']),
                'display_on_components_list' =>
                    array_key_exists('display_on_components_list', $componentConfig)
                && $componentConfig['display_on_components_list'] === true,
            ];
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

        $textComponentsIds = [];
        $textImagesComponentsIds = [];

        foreach ($components as $key => $component) {
            // TODO: Dynamize
            switch ($component['component_type']) {
                case TextComponent::class:
                    $textComponentsIds[$component['id']] = ['order' => $key + 1];
                    break;
                case TextImageComponent::class:
                    $textImagesComponentsIds[$component['id']] = ['order' => $key + 1];
                    break;
                default:
                    break;
            }
        }

        Page::saved(function ($model) use (
            $textComponentsIds,
            $textImagesComponentsIds
        ) {
            // @var Page $model
            $model->textComponents()->sync($textComponentsIds);
            $model->textImagesComponents()->sync($textImagesComponentsIds);
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