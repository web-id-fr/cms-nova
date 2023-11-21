<?php

namespace Webid\CmsNova\Modules\Articles\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleCategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => [
                'fr' => $this->faker->word,
            ],
        ];
    }
}
