<?php

namespace Webid\CmsNova\Modules\Newsletter\Tests\Helpers\Traits;

use Webid\CmsNova\Modules\Newsletter\Models\Newsletter;

trait NewsletterCreator
{
    private function createNewsletter(array $params = []): Newsletter
    {
        return Newsletter::factory()->create($params);
    }
}
