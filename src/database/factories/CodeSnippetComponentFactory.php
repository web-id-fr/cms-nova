<?php

namespace Webid\CmsNova\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webid\CmsNova\App\Models\Components\CodeSnippetComponent;
use Webid\CmsNova\Modules\JavaScript\Models\CodeSnippet;

class CodeSnippetComponentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'status' => CodeSnippetComponent::_STATUS_PUBLISHED,
            'code_snippet_id' => function () {
                return CodeSnippet::factory()->create()->getKey();
            },
        ];
    }
}
