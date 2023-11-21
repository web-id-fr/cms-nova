<?php

namespace Webid\CmsNova\Modules\Slideshow\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SlideshowFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => [
                'fr' => $this->faker->words(3, true),
            ],
            'js_controls' => true,
            'js_animate_auto' => true,
        ];
    }
}
