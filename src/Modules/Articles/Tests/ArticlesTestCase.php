<?php

namespace Webid\CmsNova\Modules\Articles\Tests;

use Illuminate\Foundation\Application;
use Webid\CmsNova\Modules\Articles\Providers\ArticlesServiceProvider;
use Webid\CmsNova\Tests\TestCase;

/**
 * @internal
 */
class ArticlesTestCase extends TestCase
{
    /**
     * @param Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        $providers = parent::getPackageProviders($app);
        array_push($providers, ArticlesServiceProvider::class);

        return $providers;
    }
}
