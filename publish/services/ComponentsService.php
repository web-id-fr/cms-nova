<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Webid\CmsNova\App\Models\Components\BreadcrumbComponent;
use Webid\CmsNova\App\Repositories\Components\BreadcrumbComponentRepository;

class ComponentsService
{
    private ?Collection $allComponents = null;

    public function getAllComponents(): Collection
    {
        if (! is_null($this->allComponents)) {
            return $this->allComponents;
        }

        $components = collect();

        $this->allComponents = $components;

        return $this->allComponents;
    }

    private function loadComponents(Collection $publishComponent, string $model, Collection $allComponents): Collection
    {
        $allPublishComponents = $this->mapItems($publishComponent, $model);
        $allPublishComponents->each(function ($component) use (&$allComponents) {
            $allComponents->push($component);
        });

        return $allComponents;
    }

    private function mapItems(Collection $items, string $model): Collection
    {
        return $items->each(function ($item) use ($model) {
            $item->component_type = $model;
            $item->component_nova = config("components.{$model}.nova");
            $item->component_image = asset(config("components.{$model}.image"));
            $item->component_name = config("components.{$model}.title");

            return $item;
        });
    }
}
