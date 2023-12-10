<?php

namespace Webid\CmsNova\App\Observers;

use App\Models\Page;
use Illuminate\Support\Str;
use Webid\CmsNova\App\Repositories\PageRepository;

class PageObserver
{
    public function __construct(private PageRepository $pageRepository)
    {
        $this->repository = $pageRepository;
    }

    public function saving(Page $page): void
    {
        $title = $page->title;
        $originalSlug = $page->getOriginal('slug') ?? [];

        // TODO: check for existing slug

        $page->slug = Str::slug($originalSlug ?? $title);
    }
}
