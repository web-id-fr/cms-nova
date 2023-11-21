<?php

namespace Webid\LanguageTool\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LanguageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Français',
            'flag' => 'fr',
        ];
    }
}
