<?php

namespace Webid\CmsNova\Modules\Slideshow\Tests;

use Webid\CmsNova\Modules\Slideshow\Providers\SlideshowServiceProvider;
use Webid\CmsNova\Tests\TestCase;

/**
 * @internal
 */
class SlideshowTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        $providers = parent::getPackageProviders($app);
        array_push($providers, SlideshowServiceProvider::class);

        return $providers;
    }
}
