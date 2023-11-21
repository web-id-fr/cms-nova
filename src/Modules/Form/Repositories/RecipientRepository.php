<?php

namespace Webid\CmsNova\Modules\Form\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Webid\CmsNova\Modules\Form\Models\Recipient;

class RecipientRepository
{
    public function __construct(private Recipient $model)
    {
    }

    public function all(): Collection
    {
        return $this->model->all();
    }
}
