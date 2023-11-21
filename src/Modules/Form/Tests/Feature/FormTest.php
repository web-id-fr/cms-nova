<?php

namespace Webid\CmsNova\Modules\Form\Tests\Feature;

use Illuminate\Database\Eloquent\Model;
use Webid\CmsNova\Modules\Form\Tests\FormTestCase;
use Webid\CmsNova\Modules\Form\Tests\Helpers\FormCreator;
use Webid\CmsNova\Tests\Helpers\Traits\TestsNovaResource;

/**
 * @internal
 */
class FormTest extends FormTestCase
{
    use FormCreator;
    use TestsNovaResource;

    protected function getResourceName(): string
    {
        return 'forms';
    }

    protected function getModel(): Model
    {
        return $this->createForm([
            'recipient_type' => array_search('email', config('fields_type')),
        ]);
    }
}
