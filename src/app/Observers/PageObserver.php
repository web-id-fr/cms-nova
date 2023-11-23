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

    public function saving(Page $template): void
    {
        $titles = $template->getTranslations('title');
        $originalSlug = $template->getOriginal('slug') ?? [];
        $value = $template->getTranslations('slug');

        $allSlug = $this->generateMissingSlugs($originalSlug, $value, $titles);

        $template->slug = $allSlug;
    }
}
