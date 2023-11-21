<?php

namespace Webid\CmsNova\Modules\Form\Tests\Feature;

use Illuminate\Database\Eloquent\Model;
use Webid\CmsNova\Modules\Form\Tests\FormTestCase;
use Webid\CmsNova\Modules\Form\Tests\Helpers\TitleFieldCreator;
use Webid\CmsNova\Tests\Helpers\Traits\TestsNovaResource;

/**
 * @internal
 */
class TitleFieldTest extends FormTestCase
{
    use TestsNovaResource;
    use TitleFieldCreator;

    protected function getResourceName(): string
    {
        return 'title-fields';
    }

    protected function getModel(): Model
    {
        return $this->createTitleField();
    }
}
