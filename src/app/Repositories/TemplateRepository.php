<?php

namespace Webid\CmsNova\App\Repositories;

use App\Models\Template;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class TemplateRepository
{
    public function __construct(private Template $model)
    {
    }

    public function getPublishedTemplates(): mixed
    {
        return $this->model
            ->where('status', Template::_STATUS_PUBLISHED)
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

    public function getBySlug(string $slug, string $language): Template
    {
        $slug = strtolower($slug);

        return $this->model
            ->where('slug', 'regexp', "\"{$language}\"[ ]*:[ ]*\"{$slug}\"")
            ->where('status', Template::_STATUS_PUBLISHED)
            ->where(function ($query) {
                $query->whereNull('publish_at')->orWhere('publish_at', '<=', Carbon::now());
            })
            ->firstOrFail()
        ;
    }

    public function getById(int $id): Template
    {
        return $this->model
            ->where('id', $id)
            ->firstOrFail()
        ;
    }

    public function getBySlugWithRelations(string $slug, string $language): Template
    {
        $slug = strtolower($slug);

        return $this->model
            ->where('slug', 'regexp', "\"{$language}\"[ ]*:[ ]*\"{$slug}\"")
            ->where('status', Template::_STATUS_PUBLISHED)
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

    public function getPublishedAndIndexedTemplates(): Collection
    {
        return $this->model
            ->where('status', Template::_STATUS_PUBLISHED)
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
     * @return Collection<Template>
     */
    public function getPublicPagesContainingArticlesLists(): Collection
    {
        return $this->model
            ->where('status', Template::_STATUS_PUBLISHED)
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
