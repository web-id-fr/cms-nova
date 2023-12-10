<?php

namespace Webid\CmsNova\Tests\Feature;

use Webid\CmsNova\Tests\TestCase;

/**
 * @internal
 */
class PreviewTest extends TestCase
{
    public const _ROUTE_INDEX = 'preview';

    /** @var array */
    protected $data;

    public function setUp(): void
    {
        parent::setUp();

        $this->data = [
            'homepage' => true,
            'title' => 'titre-en-fr',
            'slug' => 'slug-en-fr',
            'lang' => 'fr',
            'token' => uniqid(),
        ];
    }

    /** @test */
    public function we_can_make_preview()
    {
        $this->withSession([$this->data['token'] => $this->data]);
        $this->get(route(self::_ROUTE_INDEX, $this->data))->assertSuccessful();
    }

    /** @test */
    public function we_cant_make_preview_with_wrong_token()
    {
        $this->withSession(['wrong-token' => $this->data]);
        $this->get(route(self::_ROUTE_INDEX, $this->data))->assertNotFound();
    }
}
