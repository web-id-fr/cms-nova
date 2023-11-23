<?php

namespace Webid\CmsNova\App\Observers;

use App\Models\Page;
use Webid\CmsNova\App\Observers\Traits\GenerateTranslatableSlugIfNecessary;
use Webid\CmsNova\App\Repositories\PageRepository;

class PageObserver
{
    use GenerateTranslatableSlugIfNecessary;

    public function __construct(private PageRepository $pageRepository)
    {
        $this->repository = $pageRepository;
    }

    public function saving(Page $page): void
    {
        $titles = $page->getTranslations('title');
        $originalSlug = $page->getOriginal('slug') ?? [];
        $value = $page->getTranslations('slug');

        $allSlug = $this->generateMissingSlugs($originalSlug, $value, $titles);

        $page->slug = $allSlug;
    }
}
