<?php

namespace Webid\CmsNova\Modules\Newsletter\Repositories;

use Webid\CmsNova\Modules\Newsletter\Models\Newsletter;

class NewsletterRepository
{
    public function __construct(private Newsletter $model)
    {
    }

    public function store(array $data): Newsletter
    {
        return $this->model->create($data);
    }
}
