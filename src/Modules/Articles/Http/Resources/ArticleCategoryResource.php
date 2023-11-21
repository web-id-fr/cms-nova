<?php

namespace Webid\CmsNova\Modules\Articles\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Webid\CmsNova\Modules\Articles\Models\ArticleCategory;

class ArticleCategoryResource extends JsonResource
{
    /** @var ArticleCategory */
    public $resource;

    public function toArray($request)
    {
        return [
            'name' => $this->resource->name,
        ];
    }
}
