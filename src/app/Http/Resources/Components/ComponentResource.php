<?php

namespace Webid\CmsNova\App\Http\Resources\Components;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Webid\CmsNova\App\Models\Component;

class ComponentResource extends JsonResource
{
    /** @var Component */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        if (empty($this->resource->component)) {
            return [];
        }

        return [
            'component' => config("components.{$this->resource->component_type}.resource")::make($this)->resolve(),
        ];
    }
}
