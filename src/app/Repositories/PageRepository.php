<?php

namespace Webid\CmsNova\App\Repositories;

use App\Models\Page;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class PageRepository
{
    public function __construct(private Page $model)
    {
    }

    public function getPublishedPages(): mixed
    {
        return $this->model
            ->where('status', Page::_STATUS_PUBLISHED)
            ->with('related.components')
            ->get()
        ;
    }

    public function getIdForHomepage(): mixed
    {
        return $this->model->select('id')
            ->where('homepage', true)
            ->first()
        ;
    }

    public function getSlugForHomepage(): mixed
    {
        return $this->model->select('slug')
            ->where('homepage', true)
            ->with('related.components')
            ->first()
        ;
    }

    public function getBySlug(string $slug, string $language): Page
    {
        $slug = strtolower($slug);

        return $this->model
            ->where('slug', 'regexp', "\"{$language}\"[ ]*:[ ]*\"{$slug}\"")
            ->where('status', Page::_STATUS_PUBLISHED)
            ->where(function ($query) {
                $query->whereNull('publish_at')->orWhere('publish_at', '<=', Carbon::now());
            })
            ->firstOrFail()
        ;
    }

    public function getById(int $id): Page
    {
        return $this->model
            ->where('id', $id)
            ->firstOrFail()
        ;
    }

    public function getBySlugWithRelations(string $slug, string $language): Page
    {
        $slug = strtolower($slug);

        return $this->model
            ->where('slug', 'regexp', "\"{$language}\"[ ]*:[ ]*\"{$slug}\"")
            ->where('status', Page::_STATUS_PUBLISHED)
            ->where(function ($query) {
                $query->whereNull('publish_at')->orWhere('publish_at', '<=', Carbon::now());
            })->with('related.components')
            ->firstOrFail()
        ;
    }

    public function getLastCorrespondingSlugWithNumber(string $slug, string $language): mixed
    {
        $slug = strtolower($slug);

        return $this->model
            ->where('slug', 'regexp', "\"{$language}\"[ ]*:[ ]*\"{$slug}(-[1-9])\"")
            ->orderBy('id', 'desc')
            ->first()
        ;
    }

    public function getPublishedAndIndexedPages(): Collection
    {
        return $this->model
            ->where('status', Page::_STATUS_PUBLISHED)
            ->where(function ($query) {
                $query->orWhere('publish_at', '<', now())
                    ->orWhereNull('publish_at')
                ;
            })
            ->where('indexation', true)
            ->get()
        ;
    }

    /**
     * @return Collection<Page>
     */
    public function getPublicPagesContainingArticlesLists(): Collection
    {
        return $this->model
            ->where('status', Page::_STATUS_PUBLISHED)
            ->where(function ($query) {
                $query->orWhere('publish_at', '<', now())
                    ->orWhereNull('publish_at')
                ;
            })
            ->where('indexation', true)
            ->where('contains_articles_list', true)
            ->get()
        ;
    }
}
