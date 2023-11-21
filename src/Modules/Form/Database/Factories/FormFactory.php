<?php

namespace Webid\CmsNova\Modules\Form\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webid\CmsNova\Modules\Form\Models\Form;

class FormFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'title' => [
                'fr' => $this->faker->words(3, true),
            ],
            'description' => [
                'fr' => $this->faker->paragraph,
            ],
            'cta_name' => [
                'fr' => $this->faker->words(2, true),
            ],
            'status' => Form::_STATUS_PUBLISHED,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'recipient_type' => array_rand(Form::TYPE_TO_SERVICE),
        ];
    }
}
