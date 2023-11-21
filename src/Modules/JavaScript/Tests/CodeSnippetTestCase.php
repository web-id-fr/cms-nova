<?php

namespace Webid\CmsNova\Modules\JavaScript\Tests;

use Webid\CmsNova\Modules\JavaScript\Providers\JavaScriptServiceProvider;
use Webid\CmsNova\Tests\TestCase;

/**
 * @internal
 */
class CodeSnippetTestCase extends TestCase
{
    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        $providers = parent::getPackageProviders($app);
        array_push($providers, JavaScriptServiceProvider::class);

        return $providers;
    }
}
