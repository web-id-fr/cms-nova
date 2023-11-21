<?php

namespace Webid\CmsNova\Modules\Faq\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webid\CmsNova\Modules\Faq\Models\Faq;
use Webid\CmsNova\Modules\Faq\Models\FaqTheme;

class FaqFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
            'question' => [
                'fr' => $this->faker->text,
            ],
            'answer' => [
                'fr' => $this->faker->text,
            ],
            'order' => rand(1, 5),
            'status' => Faq::_STATUS_PUBLISHED,
            'faq_theme_id' => function () {
                return FaqTheme::factory()->create()->getKey();
            },
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
