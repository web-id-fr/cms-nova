<?php

namespace Webid\CmsNova\Modules\Articles\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Webid\CmsNova\Modules\Articles\Models\Article;

class ArticleRepository
{
    public function __construct(private Article $model)
    {
    }

    /**
     * @return Collection<Article>
     */
    public function getPublishedArticles(): Collection
    {
        return $this->model
            ->published()
            ->orderBy('order')
            ->get()
        ;
    }

    /**
     * @return Collection<Article>
     */
    public function getPublishedAndAllowedOnListArticles(): Collection
    {
        return $this->model
            ->published()
            ->where('not_display_in_list', false)
            ->orderBy('order')
            ->orderByRaw('CASE WHEN publish_at IS NULL THEN created_at ELSE publish_at END DESC')
            ->get()
        ;
    }

    /**
     * @return Collection<Article>
     */
    public function getPublishedAndAllowedOnListArticlesByCategory(string $lang, string $categoryName): Collection
    {
        return $this->model
            ->published()
            ->where('not_display_in_list', false)
            ->whereHas('categories', function ($query) use ($lang, $categoryName) {
                $query->whereJsonContains("name->{$lang}", $categoryName);
            })
            ->orderBy('order')
            ->orderByRaw('CASE WHEN publish_at IS NULL THEN created_at ELSE publish_at END DESC')
            ->get()
        ;
    }

    /**
     * @return Collection<Article>
     */
    public function getPublishedArticlesForLang(string $language): Collection
    {
        return $this->model
            ->publishedForLang($language)
            ->get()
        ;
    }

    public function getBySlug(string $slug, string $language): Article
    {
        $slug = strtolower($slug);

        return $this->model
            ->where('slug', 'regexp', "\"{$language}\"[ ]*:[ ]*\"{$slug}\"")
            ->publishedForLang($language)
            ->firstOrFail()
            ->load('categories')
        ;
    }

    public function getLastCorrespondingSlugWithNumber(string $slug, string $language): ?Article
    {
        $slug = strtolower($slug);

        return $this->model
            ->where('slug', 'regexp', "\"{$language}\"[ ]*:[ ]*\"{$slug}(-[1-9])\"")
            ->orderBy('id', 'desc')
            ->first()
        ;
    }

    public function latestUpdatedPublishedArticle(): ?Article
    {
        return $this->model
            ->published()
            ->orderByDesc(Article::UPDATED_AT)
            ->first()
        ;
    }

    /**
     * @return Collection<Article>
     */
    public function getPublishedPressArticles(): Collection
    {
        return $this->model
            ->published()
            ->where('article_type', Article::_TYPE_PRESS)
            ->orderBy('order')
            ->get()
        ;
    }

    /**
     * @return Collection<Article>
     */
    public function getPublishedNormalArticles(): Collection
    {
        return $this->model
            ->published()
            ->where('article_type', Article::_TYPE_NORMAL)
            ->orderBy('order')
            ->get()
        ;
    }

    /**
     * @return Collection<Article>
     */
    public function getXRelatedArticles(Article $article, int $limit): Collection
    {
        return $this->model
            ->published()
            ->whereHas('categories', function ($query) use ($article) {
                $query->whereIn('id', $article->categories->pluck('id'));
            })
            ->where('id', '!=', $article->id)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
        ;
    }
}
