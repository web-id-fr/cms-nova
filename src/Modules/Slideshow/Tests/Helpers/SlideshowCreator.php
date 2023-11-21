<?php

namespace Webid\CmsNova\Modules\Slideshow\Tests\Helpers;

use Webid\CmsNova\Modules\Slideshow\Models\Slideshow;

trait SlideshowCreator
{
    private function createSlideshow(array $params = []): Slideshow
    {
        return Slideshow::factory($params)->create();
    }
}
