<?php

namespace Webid\CmsNova\App\Http\Resources\Components;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Webid\CmsNova\App\Models\Components\CodeSnippetComponent;
use Webid\CmsNova\Modules\JavaScript\Http\Resources\CodeSnippetResource;

class CodeSnippetComponentResource extends JsonResource
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
            $this->mergeWhen(CodeSnippetComponent::_STATUS_PUBLISHED === $this->resource->component->status, [
                'id' => $this->resource->component->id,
                'name' => $this->resource->component->name,
                'code_snippet' => CodeSnippetResource::make($this->resource->component->codeSnippet)->resolve(),
                'view' => config('components.' . CodeSnippetComponent::class . '.view'),
            ]),
        ];
    }
}
