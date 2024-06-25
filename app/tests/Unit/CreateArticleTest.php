<?php

namespace Tests\Unit;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CreateArticleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    public function test_create_article():void {
        $user_id = rand(1,3);
        $dummyArticle= Article::factory()->create(['user_id' => $user_id]);
        $article = DB::table('articles')->insertGetId([
            'user_id' => $user_id,
            'title' => $dummyArticle->title,
            'content' => $dummyArticle->content,
        ]);
        $this->assertDatabaseHas('articles', ['id' => $article]);
    }
}
