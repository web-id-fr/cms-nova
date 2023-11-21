<?php

namespace Webid\CmsNova\Modules\Faq\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqThemeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'faq' => FaqResource::collection($this->resource->faqs)->resolve(),
        ];
    }
}
