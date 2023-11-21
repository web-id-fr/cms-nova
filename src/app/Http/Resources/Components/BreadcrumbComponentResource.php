<?php

namespace Webid\CmsNova\App\Http\Resources\Components;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Webid\CmsNova\App\Models\Components\BreadcrumbComponent;

class BreadcrumbComponentResource extends JsonResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->component->id,
            'name' => $this->resource->component->name,
            'view' => config('components.' . BreadcrumbComponent::class . '.view'),
        ];
    }
}
