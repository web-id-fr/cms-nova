<?php

namespace Webid\CmsNova\Modules\Form\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Webid\CmsNova\Modules\Form\Models\TitleField;

class TitleFieldRepository
{
    public function __construct(private TitleField $model)
    {
    }

    public function all(): Collection
    {
        return $this->model->all();
    }
}
