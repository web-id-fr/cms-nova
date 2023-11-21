<?php

namespace Webid\CmsNova\Tests\Helpers\Traits;

use Webid\CmsNova\App\Models\Dummy\DummyUser;

trait DummyUserCreator
{
    private function createDummyUser($params = []): DummyUser
    {
        return DummyUser::factory($params)->create();
    }
}
