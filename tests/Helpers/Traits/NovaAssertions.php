<?php

namespace Webid\CmsNova\Tests\Helpers\Traits;

use NovaTesting\NovaAssertions as BaseNovaAssertions;
use NovaTesting\NovaResponse;
use Webid\CmsNova\App\Models\Dummy\DummyUser;

trait NovaAssertions
{
    use BaseNovaAssertions;
    use DummyUserCreator;

    public function beDummyUser(DummyUser $user = null): void
    {
        if (is_null($user)) {
            $user = $this->createDummyUser();
        }

        $this->be($user);
    }

    public function createNovaResource(string $resource, array $data = []): NovaResponse
    {
        $resource = $this->resolveUriKey($resource);
        $endpoint = "nova-api/{$resource}";
        $json = $this->postJson($endpoint, $data);

        return new NovaResponse($json, compact('endpoint', 'resource'), $this);
    }
}
