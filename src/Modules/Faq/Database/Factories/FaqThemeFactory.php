<?php

namespace Webid\CmsNova\Modules\Faq\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webid\CmsNova\Modules\Faq\Models\FaqTheme;

class FaqThemeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => [
                'fr' => $this->faker->words(3, true),
            ],
            'status' => FaqTheme::_STATUS_PUBLISHED,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
