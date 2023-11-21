<?php

namespace Webid\CmsNova\Modules\Slideshow\Tests\Feature;

use Illuminate\Database\Eloquent\Model;
use Webid\CmsNova\Modules\Slideshow\Tests\Helpers\SlideCreator;
use Webid\CmsNova\Modules\Slideshow\Tests\SlideshowTestCase;
use Webid\CmsNova\Tests\Helpers\Traits\DummyUserCreator;
use Webid\CmsNova\Tests\Helpers\Traits\TestsNovaResource;

/**
 * @internal
 */
class SlideTest extends SlideshowTestCase
{
    use DummyUserCreator;
    use SlideCreator;
    use TestsNovaResource;

    protected function getResourceName(): string
    {
        return 'slides';
    }

    protected function getModel(): Model
    {
        return $this->createSlide();
    }
}
