<?php

namespace Webid\CmsNova\Modules\Slideshow\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Webid\CmsNova\Modules\Slideshow\Models\Slideshow;

class SlideshowRepository
{
    public function __construct(private Slideshow $model)
    {
    }

    public function all(): Collection
    {
        return $this->model
            ->with('slides')
            ->get()
        ;
    }

    public function find(int $id): ?Model
    {
        /** @var null|Model $slideshow */
        $slideshow = $this->model
            ->find($id)
        ;

        if ($slideshow) {
            $slideshow->with('slides');
        }

        return $slideshow;
    }
}
