<?php

namespace Webid\CmsNova\Modules\Form\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Webid\CmsNova\Modules\Form\Models\Field;

class FieldRepository
{
    public function __construct(private Field $model)
    {
    }

    public function all(): Collection
    {
        return $this->model->all();
    }
}
