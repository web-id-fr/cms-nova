<?php

namespace Webid\CmsNova\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webid\CmsNova\App\Models\Menu\MenuCustomItem;
use Webid\CmsNova\Modules\Form\Models\Form;

class MenuCustomItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => [
                'fr' => $this->faker->sentence(3),
            ],
            'url' => [
                'fr' => $this->faker->url,
            ],
            'menu_description' => [
                'fr' => $this->faker->sentence,
            ],
            'type_link' => MenuCustomItem::_LINK_URL,
        ];
    }

    public function hasForm(): self
    {
        return $this->state(function () {
            return [
                'type_link' => MenuCustomItem::_LINK_FORM,
                'form_id' => Form::factory(),
            ];
        });
    }
}
