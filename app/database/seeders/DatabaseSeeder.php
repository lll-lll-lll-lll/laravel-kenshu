<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleImage;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(3)->create()->each(function ($user) {
            // 手動自動テストでパスワードがユーザごとに変わるのが面倒なので、passwrodで統一
            $user->password = 'password';
            Article::factory(8)->create(['user_id' => $user->id])->each(function ($article) {
                ArticleImage::factory(5)->create(['article_id' => $article->id]);});
        });
    }
}
