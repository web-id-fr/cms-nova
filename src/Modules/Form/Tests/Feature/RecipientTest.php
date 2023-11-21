<?php

namespace Webid\CmsNova\Modules\Form\Tests\Feature;

use Illuminate\Database\Eloquent\Model;
use Webid\CmsNova\Modules\Form\Tests\FormTestCase;
use Webid\CmsNova\Modules\Form\Tests\Helpers\RecipientCreator;
use Webid\CmsNova\Tests\Helpers\Traits\TestsNovaResource;

/**
 * @internal
 */
class RecipientTest extends FormTestCase
{
    use RecipientCreator;
    use TestsNovaResource;

    protected function getResourceName(): string
    {
        return 'recipients';
    }

    protected function getModel(): Model
    {
        return $this->createRecipient();
    }
}
