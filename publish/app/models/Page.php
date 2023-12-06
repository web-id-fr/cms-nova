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

        foreach (config('components') as $componentKey => $componentConfiguration) {
            /** @var Collection $items */
            $items = $this->{$componentConfiguration['relationName']};

            $items->each(function ($item) use ($components, $componentKey, $componentConfiguration) {
                $item->component_type = $componentKey;
                $item->component_nova = $componentConfiguration['nova'];
                $item->component_image = $componentConfiguration['image'];
                $item->component_name = $componentConfiguration['title'];
                $components->push($item);
            });
        }

        $components = $components->sortBy(function ($item) {
            return $item->pivot->order;
        });

        $this->component_items = $components;
    }

    public function textComponents(): MorphToMany
    {
        return $this->morphedByMany(TextComponent::class, 'component')
            ->withPivot('order')
            ->orderBy('order');
    }
}
