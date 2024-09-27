<?php

namespace Database\Factories;

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
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'excerpt' => $this->faker->paragraph,
            'content' => $this->faker->paragraphs(5, true),
            'image' => $this->faker->imageUrl(),
            'category' => $this->faker->word,
            'tags' => json_encode($this->faker->words(3)),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
