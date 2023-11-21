<?php

namespace Webid\CmsNova\App\Repositories\Components;

use Illuminate\Support\Collection;
use Webid\CmsNova\App\Models\Components\NewsletterComponent;

class NewsletterComponentRepository
{
    public function __construct(private NewsletterComponent $model)
    {
    }

    public function getPublishedComponents(): Collection
    {
        return $this->model->all()
            ->where('status', NewsletterComponent::_STATUS_PUBLISHED)
        ;
    }
}
