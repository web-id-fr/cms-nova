<?php

namespace Webid\CmsNova\Tests\Helpers\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Testing\Concerns\InteractsWithAuthentication;

trait TestsNovaResource
{
    use DummyUserCreator;
    use InteractsWithAuthentication;
    use NovaAssertions;

    /** @var User */
    protected $user;

    /** @test */
    public function we_can_create_resource()
    {
        $this->actingAs($this->getUser())
            ->novaCreate($this->getResourceName())
            ->assertOk()
        ;
    }

    /** @test */
    public function we_can_show_index()
    {
        $this->actingAs($this->getUser())
            ->novaIndex($this->getResourceName())
            ->assertOk()
        ;
    }

    /** @test */
    public function we_can_show_detail()
    {
        $this->actingAs($this->getUser())
            ->novaDetail($this->getResourceName(), $this->getModel()->getKey())
            ->assertOk()
        ;
    }

    /** @test */
    public function we_can_edit_resource()
    {
        $this->actingAs($this->getUser())
            ->novaEdit($this->getResourceName(), $this->getModel()->getKey())
            ->assertOk()
        ;
    }

    abstract protected function getResourceName(): string;

    abstract protected function getModel(): Model;

    private function getUser()
    {
        if (empty($this->user)) {
            $this->user = $this->createDummyUser();
        }

        return $this->user;
    }
}
