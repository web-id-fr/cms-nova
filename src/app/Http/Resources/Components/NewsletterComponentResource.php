<?php

namespace Webid\CmsNova\App\Http\Resources\Components;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Webid\CmsNova\App\Models\Components\NewsletterComponent;

class NewsletterComponentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            $this->mergeWhen(NewsletterComponent::_STATUS_PUBLISHED === $this->resource->component->status, [
                'id' => $this->resource->component->id,
                'name' => $this->resource->component->name,
                'title' => $this->resource->component->title,
                'placeholder' => $this->resource->component->placeholder,
                'cta_name' => $this->resource->component->cta_name,
                'view' => config('components.' . NewsletterComponent::class . '.view'),
            ]),
        ];
    }
}
