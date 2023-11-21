<?php

namespace Webid\CmsNova\Modules\Faq\Tests\Feature;

use Illuminate\Database\Eloquent\Model;
use Webid\CmsNova\Modules\Faq\Tests\FaqTestCase;
use Webid\CmsNova\Modules\Faq\Tests\Helpers\FaqCreator;
use Webid\CmsNova\Tests\Helpers\Traits\TestsNovaResource;

/**
 * @internal
 */
class FaqTest extends FaqTestCase
{
    use FaqCreator;
    use TestsNovaResource;

    protected function getResourceName(): string
    {
        return 'faqs';
    }

    protected function getModel(): Model
    {
        return $this->createFaq();
    }
}
