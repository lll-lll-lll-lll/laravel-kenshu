<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleImage;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Article::factory()->create([
            'user_id' => 1,
        ]);
        Article::factory()->create([
            'user_id' => 1,
        ]);
        Article::factory()->create([
            'user_id' => 2,
        ]);
        Article::factory()->create([
            'user_id' => 3,
        ]);
        Article::factory(5)->create()->each(function ($article) {
            ArticleImage::factory(5)->create(['article_id' => $article->id]);
        });
    }
}
