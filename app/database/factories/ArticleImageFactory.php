<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ArticleImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'thumbnail_image_path' => fake()->imageUrl(640, 480, 'animals') ,
            'sub_image_path' => fake()->imageUrl(640, 480, 'animals') ,
            'created_at' => now(),
            'article_id' => Article::factory()
        ];
    }
}
