<?php

namespace Webid\CmsNova\Modules\Form\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FieldFactory extends Factory
{
    public function definition(): array
    {
        $field_type = array_rand(config('fields_type'));
        $field_name = 'Champ '.config('fields_type')[$field_type].' : '.$this->faker->unique()->words(3, true);

        return [
            'field_name' => $field_name,
            'field_type' => $field_type,
            'label' => [
                'fr' => $field_name,
            ],
            'placeholder' => [
                'fr' => $field_name,
            ],
            'required' => rand(0, 1),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
