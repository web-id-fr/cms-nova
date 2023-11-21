<?php

namespace Webid\CmsNova\Modules\Faq\Tests\Helpers;

use Webid\CmsNova\Modules\Faq\Models\Faq;

trait FaqCreator
{
    private function createFaq(array $parameters = []): Faq
    {
        return Faq::factory($parameters)->create();
    }
}
