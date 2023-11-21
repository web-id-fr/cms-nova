<?php

namespace Webid\CmsNova\Modules\Faq\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'question' => $this->resource->question,
            'answer' => $this->resource->answer,
            'order' => $this->resource->order,
        ];
    }
}
