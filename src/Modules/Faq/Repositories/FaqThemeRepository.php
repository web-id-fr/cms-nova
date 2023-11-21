<?php

namespace Webid\CmsNova\Modules\Faq\Repositories;

use Illuminate\Support\Collection;
use Webid\CmsNova\Modules\Faq\Models\FaqTheme;

class FaqThemeRepository
{
    public function __construct(private FaqTheme $model)
    {
    }

    /**
     * @return Collection<FaqTheme>
     */
    public function getPublishedFaqThemes()
    {
        return $this->model
            ->where('status', FaqTheme::_STATUS_PUBLISHED)
            ->with('faqs')
            ->get()
        ;
    }
}
