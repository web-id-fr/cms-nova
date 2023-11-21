<?php

namespace Webid\CmsNova\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DummyUserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => bcrypt('passwd'),
        ];
    }
}
