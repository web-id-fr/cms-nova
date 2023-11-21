<?php

namespace Webid\CmsNova\Modules\Form\Tests\Feature;

use Illuminate\Database\Eloquent\Model;
use Webid\CmsNova\Modules\Form\Tests\FormTestCase;
use Webid\CmsNova\Modules\Form\Tests\Helpers\ServiceCreator;
use Webid\CmsNova\Tests\Helpers\Traits\TestsNovaResource;

/**
 * @internal
 */
class ServiceTest extends FormTestCase
{
    use ServiceCreator;
    use TestsNovaResource;

    protected function getResourceName(): string
    {
        return 'services';
    }

    protected function getModel(): Model
    {
        return $this->createService();
    }
}
