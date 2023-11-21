<?php

namespace Webid\CmsNova\Modules\Form\Tests\Helpers;

use Webid\CmsNova\Modules\Form\Models\TitleField;

trait TitleFieldCreator
{
    private function createTitleField(array $parameters = []): TitleField
    {
        return TitleField::factory($parameters)->create();
    }
}
