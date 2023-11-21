<?php

namespace Webid\CmsNova\Modules\Faq\Tests;

use Webid\CmsNova\Modules\Faq\Providers\FaqServiceProvider;
use Webid\CmsNova\Tests\TestCase;

/**
 * @internal
 */
class FaqTestCase extends TestCase
{
    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        $providers = parent::getPackageProviders($app);
        array_push($providers, FaqServiceProvider::class);

        return $providers;
    }
}
