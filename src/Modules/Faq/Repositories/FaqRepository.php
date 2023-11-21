<?php

namespace Webid\CmsNova\Modules\Faq\Repositories;

use Illuminate\Support\Collection;
use Webid\CmsNova\Modules\Faq\Models\Faq;

class FaqRepository
{
    public function __construct(private Faq $model)
    {
    }

    /**
     * @return Collection<Faq>
     */
    public function getPublishedFaqs()
    {
        return $this->model->orderBy('order')
            ->where('status', Faq::_STATUS_PUBLISHED)
            ->with('faqTheme')
            ->get()
        ;
    }
}
