<?php

namespace Webid\CmsNova\Modules\Form\Tests\Helpers;

use Webid\CmsNova\Modules\Form\Models\Recipient;

trait RecipientCreator
{
    private function createRecipient(array $parameters = []): Recipient
    {
        return Recipient::factory($parameters)->create();
    }
}
