<?php

namespace Webid\CmsNova\Modules\Form\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TitleFieldFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => [
                'fr' => $this->faker->title,
            ],
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
