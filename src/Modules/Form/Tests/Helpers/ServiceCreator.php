<?php

namespace Webid\CmsNova\Modules\Form\Tests\Helpers;

use Webid\CmsNova\Modules\Form\Models\Service;

trait ServiceCreator
{
    private function createService(array $parameters = []): Service
    {
        return Service::factory($parameters)->create();
    }
}
