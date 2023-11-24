<?php

namespace Webid\CmsNova\App\Repositories\Components;

use Illuminate\Database\Eloquent\Collection;
use Webid\CmsNova\App\Models\Components\TextComponent;

class TextComponentRepository
{
    private TextComponent $model;

    public function __construct(TextComponent $model)
    {
        $this->model = $model;
    }

    public function getPublishedComponents(): Collection
    {
        return $this->model
            ->where('status', TextComponent::_STATUS_PUBLISHED)
            ->get();
    }
}
