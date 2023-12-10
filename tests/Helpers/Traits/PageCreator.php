<?php

namespace Webid\CmsNova\Tests\Helpers\Traits;

use App\Models\Page;

trait PageCreator
{
    private function createPage(array $params = []): Page
    {
        return Page::factory()->create($params);
    }

    private function createPublicPage(array $params = []): Page
    {
        return Page::factory()->create(array_merge(
            $params,
            [
                'status' => Page::_STATUS_PUBLISHED,
                'publish_at' => now()->subYear(),
                'indexation' => true,
            ]
        ));
    }

    private function createHomepagePage(array $params = []): Page
    {
        return Page::factory()->create(array_merge(
            $params,
            ['homepage' => true]
        ));
    }
}
