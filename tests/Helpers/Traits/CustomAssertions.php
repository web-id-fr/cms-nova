<?php

namespace Webid\CmsNova\Tests\Helpers\Traits;

trait CustomAssertions
{
    protected function assertStringContainsStringTimes(string $haystack, string $needle, $timesExpected): void
    {
        $this->assertEquals(
            $timesExpected,
            substr_count($haystack, $needle)
        );
    }
}
