<?php

namespace Webid\CmsNova\Modules\Newsletter\Tests;

use Webid\CmsNova\Modules\Newsletter\Providers\NewsletterServiceProvider;
use Webid\CmsNova\Tests\TestCase;

/**
 * @internal
 */
class NewsletterTestCase extends TestCase
{
    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        $providers = parent::getPackageProviders($app);
        array_push($providers, NewsletterServiceProvider::class);

        return $providers;
    }
}
