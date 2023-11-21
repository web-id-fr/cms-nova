<?php

namespace Webid\CmsNova\App\Repositories\Components;

use Illuminate\Support\Collection;
use Webid\CmsNova\App\Models\Components\CodeSnippetComponent;

class CodeSnippetComponentRepository
{
    public function __construct(private CodeSnippetComponent $model)
    {
    }

    public function getPublishedComponents(): Collection
    {
        return $this->model->all()
            ->where('status', CodeSnippetComponent::_STATUS_PUBLISHED)
        ;
    }
}
