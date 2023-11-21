<?php

namespace Webid\CmsNova\Tests\Helpers\Traits;

use Webid\CmsNova\App\Models\Components\NewsletterComponent;

trait NewsletterComponentCreator
{
    private function createNewsletterComponent(array $params = []): NewsletterComponent
    {
        return NewsletterComponent::factory()->create($params);
    }
}
