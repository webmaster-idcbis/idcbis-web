<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = fake()->sentence(6);

        return [
            'title' => rtrim($title, '.'),
            'slug' => Str::slug($title),
            'excerpt' => fake()->paragraph(2),
            'content' => '<p>'.fake()->paragraph(4).'</p>',
            'category' => fake()->randomElement([
                'investigacion',
                'sangre',
                'tejidos',
                'donacion',
                'sin-categoria',
            ]),
            'featured_image' => null,
            'status' => 'draft',
            'meta_title' => null,
            'meta_description' => null,
            'created_by' => User::factory(),
            'updated_by' => null,
            'published_at' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);
    }
}
