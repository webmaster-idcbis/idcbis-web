<?php

namespace Database\Factories;

use App\Models\PageTemplate;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PageTemplateFactory extends Factory
{
    protected $model = PageTemplate::class;

    public function definition(): array
    {
        $name = fake()->words(3, true);

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
            'content' => [
                [
                    'id' => 'element_test_1',
                    'type' => 'heading',
                    'content' => 'Título de prueba',
                    'level' => 'h2',
                ],
            ],
            'meta_title' => fake()->sentence(3),
            'meta_description' => fake()->sentence(8),
            'is_system' => false,
            'created_by' => User::factory(),
        ];
    }

    public function system(): static
    {
        return $this->state(fn () => ['is_system' => true]);
    }
}
