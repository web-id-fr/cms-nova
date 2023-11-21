<?php

namespace Webid\CmsNova\Modules\JavaScript\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CodeSnippetFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
            'source_code' => sprintf(
                'console.log("%s")',
                $this->faker->sentence(),
            ),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
