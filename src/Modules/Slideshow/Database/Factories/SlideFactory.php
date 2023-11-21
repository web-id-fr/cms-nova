<?php

namespace Webid\CmsNova\Modules\Slideshow\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SlideFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => [
                'fr' => $this->faker->words(3, true),
            ],
            'description' => [
                'fr' => $this->faker->paragraph,
            ],
            'cta_name' => [
                'fr' => $this->faker->words(3, true),
            ],
            'cta_url' => [
                'fr' => $this->faker->url,
            ],
            'url' => [
                'fr' => $this->faker->url,
            ],
            'image' => 'fake.png',
            'image_alt' => [
                'fr' => 'image alt',
            ],
        ];
    }
}
