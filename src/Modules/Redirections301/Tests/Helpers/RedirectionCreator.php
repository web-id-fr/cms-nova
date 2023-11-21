<?php

namespace Webid\CmsNova\Modules\Redirections301\Tests\Helpers;

use Webid\CmsNova\Modules\Redirections301\Models\Redirection;

trait RedirectionCreator
{
    private function createRedirection(array $params = []): Redirection
    {
        return Redirection::factory($params)->create();
    }
}
