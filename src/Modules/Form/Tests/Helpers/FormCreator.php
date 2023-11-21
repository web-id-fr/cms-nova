<?php

namespace Webid\CmsNova\Modules\Form\Tests\Helpers;

use Webid\CmsNova\Modules\Form\Models\Form;

trait FormCreator
{
    private function createForm(array $parameters = []): Form
    {
        return Form::factory($parameters)->create();
    }
}
