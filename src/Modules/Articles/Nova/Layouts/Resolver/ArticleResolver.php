<?php

namespace Webid\CmsNova\Modules\Articles\Nova\Layouts\Resolver;

use Illuminate\Support\Collection;
use Webid\CmsNova\Modules\Articles\Models\Article;
use Webid\CmsNova\Modules\Slideshow\Http\Resources\SlideshowResource;
use Webid\CmsNova\Modules\Slideshow\Repositories\SlideshowRepository;
use Whitecube\NovaFlexibleContent\Layouts\Collection as layoutsCollection;
use Whitecube\NovaFlexibleContent\Value\ResolverInterface;

class ArticleResolver implements ResolverInterface
{
    /**
     * @param Article           $model
     * @param string            $attribute
     * @param layoutsCollection $layouts
     *
     * @return mixed
     */
    public function get($model, $attribute, $layouts)
    {
        $value = $this->extractValueFromResource($model, $attribute);

        return collect($value)->map(function ($item) use ($layouts) {
            $layout = $layouts->find($item->layout);

            if (! $layout) {
                return '';
            }

            if ('slideshow' === $item->layout) {
                return $layout->duplicateAndHydrate($item->key, [
                    'slideshow_select' => $item->attributes['id'],
                ]);
            }

            return $layout->duplicateAndHydrate($item->key, (array) $item->attributes);
        })->filter()->values();
    }

    /**
     * @param Article    $model
     * @param string     $attribute
     * @param Collection $value
     *
     * @return mixed
     */
    public function set($model, $attribute, $value)
    {
        $class = get_class($model);

        return $model->{$attribute} = $value->map(function ($group) use ($class) {
            $attributes = $group->getAttributes();

            if ('slideshow' === $group->name()) {
                $slideshowId = $group->slideshow_select;

                $class::saved(function ($model) use ($slideshowId) {
                    $model->slideshows()->sync($slideshowId);
                });

                $attributes = [
                    'id' => $slideshowId,
                    'slideshow_select' => SlideshowResource::make(
                        app(SlideshowRepository::class)->find($slideshowId)
                    )->resolve(),
                ];
            }

            if (! empty($attributes['media'])) {
                $attributes['full_media'] = media_full_url($attributes['media']);
            } else {
                $attributes['full_media'] = '';
            }

            if (! empty($attributes['video'])) {
                $attributes['full_video'] = media_full_url($attributes['video']);
            } else {
                $attributes['full_video'] = '';
            }

            if (! empty($attributes['image'])) {
                $attributes['full_image'] = media_full_url($attributes['image']);
            } else {
                $attributes['full_image'] = '';
            }

            $attributes['layout'] = $group->name();

            return [
                'layout' => $group->name(),
                'key' => $group->key(),
                'attributes' => $attributes,
            ];
        });
    }

    /**
     * @param Article $resource
     * @param string  $attribute
     *
     * @return array
     */
    protected function extractValueFromResource($resource, $attribute)
    {
        $value = data_get($resource, str_replace('->', '.', $attribute)) ?? [];

        if ($value instanceof Collection) {
            $value = $value->toArray();
        } elseif (is_string($value)) {
            $value = json_decode($value) ?? [];
        }

        if (! is_array($value)) {
            return [];
        }

        return array_map(function ($item) {
            return is_array($item) ? (object) $item : $item;
        }, $value);
    }
}
