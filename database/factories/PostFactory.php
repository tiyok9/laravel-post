<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Post::class;

    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'title' => $this->faker->sentence(3),
            'content' => $this->faker->paragraph(5),
            'is_draft' => $this->faker->boolean(20), // 20% kemungkinan jadi draft
            'published_at' => $this->faker->optional(0.8)->dateTime(), // 80% memiliki published_at
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
