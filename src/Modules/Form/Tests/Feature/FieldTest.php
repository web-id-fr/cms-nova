<?php

namespace Webid\CmsNova\Modules\Form\Tests\Feature;

use Illuminate\Database\Eloquent\Model;
use Webid\CmsNova\Modules\Form\Tests\FormTestCase;
use Webid\CmsNova\Modules\Form\Tests\Helpers\FieldCreator;
use Webid\CmsNova\Tests\Helpers\Traits\TestsNovaResource;

/**
 * @internal
 */
class FieldTest extends FormTestCase
{
    use FieldCreator;
    use TestsNovaResource;

    protected function getResourceName(): string
    {
        return 'fields';
    }

    protected function getModel(): Model
    {
        return $this->createField();
    }
}
