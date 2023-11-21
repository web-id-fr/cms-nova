<?php

namespace Webid\CmsNova\Modules\Redirections301\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RedirectionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'source_url' => $this->faker->url,
            'destination_url' => $this->faker->url,
        ];
    }
}
