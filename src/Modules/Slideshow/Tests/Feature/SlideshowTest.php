<?php

namespace Webid\CmsNova\Modules\Slideshow\Tests\Feature;

use Illuminate\Database\Eloquent\Model;
use Webid\CmsNova\Modules\Slideshow\Tests\Helpers\SlideshowCreator;
use Webid\CmsNova\Modules\Slideshow\Tests\SlideshowTestCase;
use Webid\CmsNova\Tests\Helpers\Traits\DummyUserCreator;
use Webid\CmsNova\Tests\Helpers\Traits\TestsNovaResource;

/**
 * @internal
 */
class SlideshowTest extends SlideshowTestCase
{
    use DummyUserCreator;
    use SlideshowCreator;
    use TestsNovaResource;

    protected function getResourceName(): string
    {
        return 'slideshows';
    }

    protected function getModel(): Model
    {
        return $this->createSlideshow();
    }
}
