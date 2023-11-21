<?php

namespace Webid\ImageItemField;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\SupportsDependentFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Webid\CmsNova\Modules\Slideshow\Models\Slideshow;
use Webid\CmsNova\Modules\Slideshow\Repositories\SlideRepository;

class ImageItemField extends Field
{
    use SupportsDependentFields;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'image-item-field';

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(string $name, ?string $attribute = null, callable $resolveCallback = null)
    {
        $slideRepository = app()->make(SlideRepository::class);

        $allSlide = $slideRepository->all();
        $allSlide->map(function ($slide) {
            if (! empty($slide->image)) {
                $slide->imageAsset = config('cms.image_path') . $slide->image->path;
            }

            return $slide;
        });

        $this->withMeta(['items' => $allSlide]);

        parent::__construct($name, $attribute, $resolveCallback);
    }

    /**
     * @param string $requestAttribute
     * @param object $model
     * @param string $attribute
     */
    public function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        $slideItems = $request[$requestAttribute];
        $slideItems = collect(json_decode($slideItems, true));

        $slideItemIds = [];

        $slideItems->each(function ($serviceItem, $key) use (&$slideItemIds) {
            $slideItemIds[$serviceItem['id']] = ['order' => (int) $key + 1];
        });

        Slideshow::saved(function ($model) use ($slideItemIds) {
            $model->slides()->sync($slideItemIds);
        });
    }

    /**
     * @param mixed $resource
     * @param null  $attribute
     */
    public function resolve($resource, $attribute = null)
    {
        parent::resolve($resource, $attribute);
        $resource->chargeSlideItems();

        $valueInArray = [];
        $resource->slide_items->each(function ($item) use (&$valueInArray) {
            $valueInArray[] = $item;
        });

        if ($valueInArray) {
            $this->value = $valueInArray;
        }
    }
}
