<?php

namespace Webid\CmsNova\Modules\Articles\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Webid\CmsNova\Modules\Articles\Models\ArticleCategory;

class ArticleCategoryRepository
{
    public function __construct(private ArticleCategory $model)
    {
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function getCategoriesWithArticles(): Collection
    {
        return $this->model->whereHas('articles')->get();
    }

    public function getCategoryByName(string $categoryName, string $language): ArticleCategory
    {
        return $this->model
            ->whereRaw(
                "JSON_UNQUOTE(LOWER(JSON_EXTRACT(name, '$.{$language}'))) = ?",
                [strtolower($categoryName)]
            )
            ->firstOrFail()
        ;
    }
}
