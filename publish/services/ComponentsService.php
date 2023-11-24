<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Webid\CmsNova\App\Nova\Components\TextComponent;
use Webid\CmsNova\App\Repositories\Components\TextComponentRepository;

class ComponentsService
{
    private ?Collection $allComponents = null;
    private TextComponentRepository $textComponentRepository;

    public function getAllComponents(): Collection
    {
        if (! is_null($this->allComponents)) {
            return $this->allComponents;
        }

        $this->textComponentRepository = app(TextComponentRepository::class);

        $textComponents = collect();
        $components = collect();

        $this->loadComponents(
            $this->textComponentRepository->getPublishedComponents(),
            TextComponent::class,
            $textComponents
        );

        $components[config('components.'.TextComponent::class.'.title')] = $textComponents;

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
