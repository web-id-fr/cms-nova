<?php

namespace Webid\CmsNova\Database\Factories;

use App\Models\Template;
use Illuminate\Database\Eloquent\Factories\Factory;

class TemplateFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => [
                'fr' => $this->faker->words(3, true),
                'en' => $this->faker->words(3, true),
            ],
            'slug' => [
                'fr' => $this->faker->slug,
                'en' => $this->faker->slug,
            ],
            'status' => Template::_STATUS_PUBLISHED,
            'indexation' => rand(0, 1),
            'follow' => rand(0, 1),
            'publish_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    }
}
