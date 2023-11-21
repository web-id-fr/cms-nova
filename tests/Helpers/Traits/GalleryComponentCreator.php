<?php

namespace Webid\CmsNova\Tests\Helpers\Traits;

use Webid\CmsNova\App\Models\Components\GalleryComponent;

trait GalleryComponentCreator
{
    private function createGalleryComponent(array $params = []): GalleryComponent
    {
        return GalleryComponent::factory()->create($params);
    }
}
