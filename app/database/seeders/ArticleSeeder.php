<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Article::factory()->create([
            'title' => 'Article1',
            'content' => 'Content1',
            'user_id' => 1,
        ]);
        Article::factory()->create([
            'title' => 'Article11',
            'content' => 'Content11',
            'user_id' => 1,
        ]);
        Article::factory()->create([
            'title' => 'Article2',
            'content' => 'Content2',
            'user_id' => 2,
        ]);
        Article::factory()->create([
            'title' => 'Article3',
            'content' => 'Content3',
            'user_id' => 3,
        ]);
    }
}
