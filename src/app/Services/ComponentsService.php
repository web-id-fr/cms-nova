<?php

namespace Webid\CmsNova\App\Services;

use Illuminate\Support\Collection;

class ComponentsService
{
    private ?Collection $allComponents = null;

    public function getAllComponents(): Collection
    {
        if (! is_null($this->allComponents)) {
            return $this->allComponents;
        }

        $allComponents = collect();

        $componentsConfig = config('components');
        foreach ($componentsConfig as $componentKey => $componentConfig) {
            $repository = app($componentConfig['repository']);
            $components = collect();

            $this->loadComponents(
                $repository->getPublishedComponents(),
                $componentConfig['model'],
                $components
            );

            $allComponents[] = $components;
        }

        $this->allComponents = $allComponents;

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
