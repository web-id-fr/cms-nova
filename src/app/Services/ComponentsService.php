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
                $componentConfig,
                $components
            );

            $allComponents[] = $components;
        }

        $this->allComponents = $allComponents;

        return $this->allComponents;
    }

    private function loadComponents(Collection $publishComponent, array $componentConfiguration, Collection $allComponents): Collection
    {
        $allPublishComponents = $this->mapItems($publishComponent, $componentConfiguration);
        $allPublishComponents->each(function ($component) use (&$allComponents) {
            $allComponents->push($component);
        });

        return $allComponents;
    }

    private function mapItems(Collection $items, array $componentConfiguration): Collection
    {
        return $items->each(function ($item) use ($componentConfiguration) {
            $item->component_type = $componentConfiguration['model'];
            $item->component_nova = $componentConfiguration['nova'];
            $item->component_image = $componentConfiguration['image'];
            $item->component_name = $componentConfiguration['title'];

            return $item;
        });
    }
}
