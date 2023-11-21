<?php

namespace Webid\CmsNova\Modules\Slideshow\Tests\Helpers;

use Webid\CmsNova\Modules\Slideshow\Models\Slide;

trait SlideCreator
{
    private function createSlide(array $params = []): Slide
    {
        return Slide::factory($params)->create();
    }
}
