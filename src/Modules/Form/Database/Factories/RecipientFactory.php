<?php

namespace Webid\CmsNova\Modules\Form\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RecipientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
