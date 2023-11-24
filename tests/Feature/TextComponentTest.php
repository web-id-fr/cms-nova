<?php

namespace Tests\Feature\Components;

use Illuminate\Database\Eloquent\Model;
use Tests\Helpers\Traits\TestsComponentInPage;
use Tests\Helpers\Traits\TestsNovaResource;
use Tests\TestCase;
use Webid\CmsNova\App\Models\Components\TextComponent;

class TextComponentTest extends TestCase
{
    use TestsNovaResource,
        TestsComponentInPage;

    protected function getResourceName(): string
    {
        return 'text-components';
    }

    protected function getModel(): Model
    {
        //$this->seed(TextComponentSeeder::class);

        return TextComponent::all()->first();
    }

    protected function componentDataToSeeInPage(Model $component): array
    {
        return [
            // TODO: Implement componentDataToSeeInPage() method.
        ];
    }
}
