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
    }
}
