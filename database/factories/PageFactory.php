<?php

namespace Database\Factories;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'slug' => $this->faker->slug,
            'status' => $this->faker->randomElement(['draft', 'published', 'archived']),
            'meta_description' => $this->faker->paragraph,
            'created_by' => User::factory(),
            'updated_by' => User::factory(),
            'published_at' => $this->faker->optional()->dateTime,
        ];
    }

    public function published()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'published',
                'published_at' => now(),
            ];
        });
    }

    public function draft()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'draft',
                'published_at' => null,
            ];
        });
    }
}
