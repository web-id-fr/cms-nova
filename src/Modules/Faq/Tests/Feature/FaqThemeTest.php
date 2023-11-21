<?php

namespace Webid\CmsNova\Modules\Faq\Tests\Feature;

use Illuminate\Database\Eloquent\Model;
use Webid\CmsNova\Modules\Faq\Tests\FaqTestCase;
use Webid\CmsNova\Modules\Faq\Tests\Helpers\FaqThemeCreator;
use Webid\CmsNova\Tests\Helpers\Traits\TestsNovaResource;

/**
 * @internal
 */
class FaqThemeTest extends FaqTestCase
{
    use FaqThemeCreator;
    use TestsNovaResource;

    protected function getResourceName(): string
    {
        return 'faq-themes';
    }

    protected function getModel(): Model
    {
        return $this->createFaqTheme();
    }
}
