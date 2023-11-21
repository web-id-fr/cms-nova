<?php

namespace Webid\CmsNova\Modules\Slideshow\Repositories;

use Illuminate\Support\Collection;
use Webid\CmsNova\Modules\Slideshow\Models\Slide;

class SlideRepository
{
    public function __construct(private Slide $model)
    {
    }

    public function all(): Collection
    {
        return $this->model->all();
    }
}
