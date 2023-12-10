<?php

namespace Webid\CmsNova\Modules\Components\TextComponent\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Webid\CmsNova\Modules\Components\TextComponent\Models\TextComponent;

class TextComponentRepository
{
    public function __construct(private readonly TextComponent $model)
    {
    }

    public function getPublishedComponents(): Collection
    {
        return $this->model
            ->where('status', TextComponent::_STATUS_PUBLISHED)
            ->get();
    }
}
