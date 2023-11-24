<?php

namespace Webid\CmsNova\App\Http\Resources\Components;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Webid\CmsNova\App\Models\Components\TextComponent;

class TextComponentResource extends JsonResource
{
    /**
         * @param Request $request
         *
         * @return array
         */
    public function toArray($request)
    {
        return [
            $this->mergeWhen($this->resource->component->status === TextComponent::_STATUS_PUBLISHED, [
                'id' => $this->resource->component->id,
                'name' => $this->resource->component->name,
                'view' =>  config("components." . TextComponent::class . ".view"),
            ]),
        ];
    }
}
