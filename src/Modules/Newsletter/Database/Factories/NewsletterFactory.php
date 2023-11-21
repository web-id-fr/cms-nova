<?php

namespace Webid\CmsNova\Modules\Newsletter\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NewsletterFactory extends Factory
{
    public function definition(): array
    {
        return [
            'email' => $this->faker->email,
            'lang' => $this->faker->locale,
        ];
    }
}
