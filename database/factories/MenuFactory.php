<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    protected $model = Menu::class;

    public function definition()
    {
        return [
            'name' => $this->faker->words(2, true),
            'location' => $this->faker->randomElement(['header', 'footer']),
            'items' => [
                [
                    'type' => 'url',
                    'title' => $this->faker->word,
                    'url' => $this->faker->url,
                    'target' => '_self',
                    'order' => 0
                ]
            ],
            'is_active' => true,
            'order' => $this->faker->numberBetween(1, 10)
        ];
    }

    public function header()
    {
        return $this->state(function (array $attributes) {
            return [
                'location' => 'header'
            ];
        });
    }

    public function footer()
    {
        return $this->state(function (array $attributes) {
            return [
                'location' => 'footer'
            ];
        });
    }

    public function inactive()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => false
            ];
        });
    }
}
