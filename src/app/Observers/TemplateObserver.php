<?php

namespace Webid\CmsNova\App\Observers;

use App\Models\Template;
use Webid\CmsNova\App\Observers\Traits\GenerateTranslatableSlugIfNecessary;
use Webid\CmsNova\App\Repositories\TemplateRepository;

class TemplateObserver
{
    use GenerateTranslatableSlugIfNecessary;

    public function __construct(private TemplateRepository $templateRepository)
    {
        $this->repository = $templateRepository;
    }

    public function saving(Template $template): void
    {
        $titles = $template->getTranslations('title');
        $originalSlug = $template->getOriginal('slug') ?? [];
        $value = $template->getTranslations('slug');

        $allSlug = $this->generateMissingSlugs($originalSlug, $value, $titles);

        $template->slug = $allSlug;
    }
}
