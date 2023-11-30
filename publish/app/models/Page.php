<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;
use Webid\CmsNova\App\Models\BaseTemplate;
use Webid\CmsNova\Modules\Components\TextComponent\Models\TextComponent;

class Page extends BaseTemplate
{
    public Collection $component_items;

    public function chargeComponents(): void
    {
        $components = collect();

        $this->mapItems($this->textComponents, TextComponent::class, $components);

        $components = $components->sortBy(function ($item) {
            return $item->pivot->order;
        });

        $this->component_items = $components;
    }

    protected function mapItems(Collection $items, string $model, Collection &$components): Collection
    {
        $items->each(function ($item) use (&$components, $model) {
            $item->component_type = $model;
            $item->component_nova = config("components.{$model}.nova");
            $item->component_image = asset(config("components.{$model}.image"));
            $item->component_name = config("components.{$model}.title");
            $components->push($item);
        });

        return $components;
    }

    public function textComponents(): MorphToMany
    {
        return $this->morphedByMany(TextComponent::class, 'component')
            ->withPivot('order')
            ->orderBy('order');
    }
}
