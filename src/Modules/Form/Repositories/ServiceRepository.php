<?php

namespace Webid\CmsNova\Modules\Form\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Webid\CmsNova\Modules\Form\Models\Service;

class ServiceRepository
{
    public function __construct(private Service $model)
    {
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function get(int $id): ?Service
    {
        return $this->model->where('id', $id)->first();
    }
}
