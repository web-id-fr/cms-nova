<?php

namespace Webid\CmsNova\Modules\Form\Tests\Helpers;

use Webid\CmsNova\Modules\Form\Models\Field;

trait FieldCreator
{
    private function createField(array $parameters = []): Field
    {
        return Field::factory($parameters)->create();
    }
}
