<?php

namespace Webid\CmsNova\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webid\CmsNova\App\Models\Components\NewsletterComponent;

class NewsletterComponentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'status' => NewsletterComponent::_STATUS_PUBLISHED,
            'title' => $this->faker->word,
            'cta_name' => $this->faker->word,
            'placeholder' => $this->faker->words(3, true),
        ];
    }
}
