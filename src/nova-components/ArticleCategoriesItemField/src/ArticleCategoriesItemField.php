<?php

namespace Webid\ArticleCategoriesItemField;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;
use Webid\CmsNova\Modules\Articles\Models\Article;
use Webid\CmsNova\Modules\Articles\Repositories\ArticleCategoryRepository;

class ArticleCategoriesItemField extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'article-categories-item-field';

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(string $name, ?string $attribute = null, callable $resolveCallback = null)
    {
        $articleCategoryRepository = app()->make(ArticleCategoryRepository::class);
        $allField = $articleCategoryRepository->all();

        $this->withMeta(['items' => $allField]);

        parent::__construct($name, $attribute, $resolveCallback);
    }

    /**
     * @param mixed $resource
     * @param null  $attribute
     */
    public function resolve($resource, $attribute = null): void
    {
        parent::resolve($resource, $attribute);
        $resource->categories();

        $valueInArray = [];
        $resource->categories->each(function ($item) use (&$valueInArray) {
            $valueInArray[] = $item;
        });

        if ($valueInArray) {
            $this->value = $valueInArray;
        }
    }

    public function single(bool $isSingle): ArticleCategoriesItemField
    {
        if ($isSingle) {
            return $this->withMeta(['limit' => 1]);
        }

        return $this->withMeta(['limit' => 100]);
    }

    /**
     * @param string $requestAttribute
     * @param object $model
     * @param string $attribute
     *
     * @return mixed
     */
    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        $articleCategoryItems = $request[$requestAttribute];
        $articleCategoryItems = collect(json_decode($articleCategoryItems, true));

        $articleCategoryItemIds = [];

        $articleCategoryItems->each(function ($articleCategoryItem, $key) use (&$articleCategoryItemIds) {
            $articleCategoryItemIds[] = $articleCategoryItem['id'];
        });

        Article::saved(function ($model) use ($articleCategoryItemIds) {
            $model->categories()->sync($articleCategoryItemIds);
        });
    }
}
