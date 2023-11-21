<?php

namespace Webid\CmsNova\App\Repositories\Components;

use Illuminate\Database\Eloquent\Collection;
use Webid\CmsNova\App\Models\Components\BreadcrumbComponent;

class BreadcrumbComponentRepository
{
    private BreadcrumbComponent $model;

    public function __construct(BreadcrumbComponent $model)
    {
        $this->model = $model;
    }

    public function getPublishedComponents(): Collection
    {
        return $this->model
            ->get()
        ;
    }
}
