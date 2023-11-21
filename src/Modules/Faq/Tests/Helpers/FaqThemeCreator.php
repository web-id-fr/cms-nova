<?php

namespace Webid\CmsNova\Modules\Faq\Tests\Helpers;

use Webid\CmsNova\Modules\Faq\Models\FaqTheme;

trait FaqThemeCreator
{
    private function createFaqTheme(array $parameters = []): FaqTheme
    {
        return FaqTheme::factory($parameters)->create();
    }
}
