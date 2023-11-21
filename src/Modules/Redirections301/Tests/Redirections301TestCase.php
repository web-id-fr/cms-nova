<?php

namespace Webid\CmsNova\Modules\Redirections301\Tests;

use Webid\CmsNova\Modules\Redirections301\Providers\Redirections301ServiceProvider;
use Webid\CmsNova\Tests\TestCase;

/**
 * @internal
 */
class Redirections301TestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        $providers = parent::getPackageProviders($app);
        array_push($providers, Redirections301ServiceProvider::class);

        return $providers;
    }
}
