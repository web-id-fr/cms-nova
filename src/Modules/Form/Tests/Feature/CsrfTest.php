<?php

namespace Webid\CmsNova\Modules\Form\Tests\Feature;

use Webid\CmsNova\Modules\Form\Tests\FormTestCase;

/**
 * @internal
 */
class CsrfTest extends FormTestCase
{
    /** @test */
    public function route_works()
    {
        $response = $this->get(route('csrf.index'))->assertSuccessful();

        $this->assertEquals(csrf_token(), $response->content());
    }
}
